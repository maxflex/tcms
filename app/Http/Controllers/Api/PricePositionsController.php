<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Resources\PricePositionResource;
use App\Models\PricePosition;

class PricePositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = PricePosition::query()
            ->where('price_section_id', $request->input('id') ?: null)
            ->orderBy('position')
            ->get();
        return PricePositionResource::collection($items);
    }


    public function store(Request $request)
    {
        $pricePosition = PricePosition::create($request->input());
        $pricePosition->handleTags($request);
        return $pricePosition->fresh();
    }


    public function show($id)
    {
        return PricePosition::find($id)->append('tags');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pricePosition = PricePosition::find($id);
        $pricePosition->handleTags($request);
        $pricePosition->update($request->input());
        return $pricePosition;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pricePosition = PricePosition::find($id);
        $pricePosition->tagEntities()->delete();
        $pricePosition->delete();
    }
}
