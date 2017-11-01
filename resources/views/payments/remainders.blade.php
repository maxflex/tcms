@extends('app')
@section('title')
    Счёт
@stop
@section('controller', 'PaymentRemainders')

@section('content')
    <table class="table table-hover reverse-borders">
        <thead>
            <tr>
                <td></td>
                <td>пополнения</td>
                <td>расходные операции</td>
                <td>остаток на конец дня</td>
                <td>статья</td>
                <td>назначение операции</td>
            </tr>
        </thead>
        <tbody ng-repeat="(date, items) in data.items">
            <tr>
                <td colspan="3"></td>
                <td>@{{ data.totals[date].sum | number }}</td>
                <td colspan="2" class="text-gray">
                    @{{ data.totals[date].comment }}
                </td>
            </tr>
            <tr ng-repeat="item in items" ng-class="{'last-date': $last}">
                <td width='120'>
                    <span ng-show="$last">@{{ date | date:'dd.MM.yyyy' }}</span>
                </td>
                <td width='120'>
                    <span ng-show="item.addressee_id == source_id" class="text-success">+@{{ item.sum | number }}</span>
                </td>
                <td width='120'>
                    <span ng-show="item.source_id == source_id" class="text-danger">-@{{ item.sum | number }}</span>
                </td>
                <td width='120'>
                </td>
                <td width='300'>
                    <span ng-if="item.expenditure_id">@{{ expenditures[item.expenditure_id].name }}</span>
                    {{-- <span ng-if="item.expenditure_id == -1">входящий остаток</span> --}}
                </td>
                <td>
                    @{{ item.purpose }}
                </td>
            </tr>
        </tbody>
    </table>

    <pagination
          ng-model="current_page"
          ng-change="pageChanged()"
          ng-hide="!data || data.item_cnt < {{ \App\Http\Controllers\PaymentsController::PER_PAGE }}"
          total-items="data.item_cnt"
          max-size="10"
          items-per-page="{{ \App\Http\Controllers\PaymentsController::PER_PAGE }}"
          first-text="«"
          last-text="»"
          previous-text="«"
          next-text="»"
    >
    </pagination>
@stop

<style>
    .table > tbody + tbody {
        border-top: none !important;
    }
    .table tr td {
        font-size: 12px;
    }
    .table tr td {
        border-bottom: none !important;
    }
    .table tr.last-date td {
        border-bottom: 1px solid #ddd !important;
    }
</style>