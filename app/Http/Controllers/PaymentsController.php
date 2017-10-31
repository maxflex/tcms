<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PaymentsController extends Controller
{
    const VIEWS_FOLDER = 'payments.';
    const PER_PAGE = 100;

    public function remainders(Request $request)
    {
        if (! allowed(\Rights::PAYMENTS)) {
            return view('errors.not_allowed');
        }

        return view(self::VIEWS_FOLDER . 'remainders')->with(ngInit([
            // 'sources'       => egerep('payment_sources')->whereNotNull('remainder_date')->orderBy('position')->get(),
            'expenditures'  => egerep('payment_expenditures')->get()->keyBy('id')
        ]));
    }

}