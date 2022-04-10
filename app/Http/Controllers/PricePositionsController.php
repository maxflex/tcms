<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\PricePosition;
use App\Models\PriceSection;

class PricePositionsController extends Controller
{
    public function create(Request $request)
    {
        // $request->validate(['id' => ['required', 'exists:price_sections,id']]);
        $priceSection = PriceSection::find($request->input('id'));
        $price_sections = PriceSection::select('id', 'name')->get();
        return view('prices.positions.create')->with(ngInit([
            'price_sections' => $price_sections,
            'model' => new PricePosition([
                'price_section_id' => $priceSection->id,
            ]),
        ]))->with([
            'section_name' => $priceSection->name,
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $price_sections = PriceSection::select('id', 'name')->get();
        return view('prices.positions.edit')->with(ngInit(compact('id', 'price_sections')));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
