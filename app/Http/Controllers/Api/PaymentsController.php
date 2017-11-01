<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Payment\Source;
use DB;

class PaymentsController extends Controller
{
    public function remainders(Request $request)
    {
        $page = isset($request->page) ? $request->page : 1;
        $source = egerep('payment_sources')->whereId($request->source_id)->first();

        // $sources = egerep('payment_sources')->get();
        // $sources = egerep('payment_sources')->whereId(1)->get();

        // кол-во элементов
        $query      = egerep('payments')->where('source_id', $source->id)->orWhere('addressee_id', $source->id);
        $item_cnt   = cloneQuery($query)->count();
        $items      = cloneQuery($query)->orderBy('date', 'desc')->take(\App\Http\Controllers\PaymentsController::PER_PAGE)->skip(($page - 1) * \App\Http\Controllers\PaymentsController::PER_PAGE)->get();

        $items = collect($items)->groupBy('date')->all();

        // суммы дней
        $totals = [];
        foreach($items as $date => $data) {
            $remainder = $source->remainder;
            if ($date > $source->remainder_date) {
                $remainder += egerep('payments')->where('addressee_id', $source->id)->where('date', '<=', $date)->where('date', '>', $source->remainder_date)->sum('sum');
                $remainder -= egerep('payments')->where('source_id', $source->id)->where('date', '<=', $date)->where('date', '>', $source->remainder_date)->sum('sum');
            }
            if ($date < $source->remainder_date) {
                $remainder -= egerep('payments')->where('addressee_id', $source->id)->where('date', '>=', $date)->where('date', '<', $source->remainder_date)->sum('sum');
                $remainder += egerep('payments')->where('source_id', $source->id)->where('date', '>=', $date)->where('date', '<', $source->remainder_date)->sum('sum');
            }
            // если date == source->remainder_date, то будет перезаписано ниже
            $totals[$date] = ['sum' => $remainder];
        }

        // inject входящий остаток
        if ($source->remainder_date >= array_keys($items)[count($items) - 1] && $source->remainder_date <= array_keys($items)[0]) {
            $totals[$source->remainder_date] = [
                'sum'       => $source->remainder,
                'comment'   => 'входящий остаток',
            ];
            if (! isset($items[$source->remainder_date])) {
                $items[$source->remainder_date] = [[]];
                ksort($items);
                $items = array_reverse($items);
            }
        }

        return compact('items', 'totals', 'item_cnt');
    }
}
