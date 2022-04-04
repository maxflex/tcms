<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\Payment\Source;
use App\Models\Payment\Expenditure;
use App\Models\Payment\ExpenditureGroup;
use App\Service\Rights;

class PaymentsController extends Controller
{
    const VIEWS_FOLDER = 'payments.';
    const PER_PAGE = 100;

    public function index(Request $request)
    {
        if (!allowed(Rights::PAYSTREAM)) {
            return view('errors.not_allowed');
        }

        return view(self::VIEWS_FOLDER . 'index')->with(ngInit([
            'current_page' => $request->page,
            'fresh_payment' => new Payment,
            'sources'      => Source::orderBy('position')->select('id', 'name')->get(),
            'expenditures' => ExpenditureGroup::getAll(),
        ]));
    }

    public function remainders(Request $request)
    {
        if (!allowed(Rights::PAYSTREAM)) {
            return view('errors.not_allowed');
        }

        return view(self::VIEWS_FOLDER . 'remainders')->with(ngInit([
            // 'page' => $request->page,
            'sources' => Source::whereNotNull('remainder_date')->orderBy('position')->get(),
            'expenditures' => collect(Expenditure::get())->keyBy('id')
            // 'item_cnt' => $item_cnt,
        ]));
    }
}
