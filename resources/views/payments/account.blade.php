@extends('app')
@section('title')
    Счёт
@stop
@section('controller', 'PaymentAccount')

@section('content')
    <table class="table table-hover reverse-borders">
        <thead>
            <tr>
                <td></td>
                <td>пополнения</td>
                <td>расходные операции</td>
                <td>остаток на конец дня</td>
                <td>остаток</td>
                <td>статья</td>
                <td>назначение операции</td>
            </tr>
        </thead>
        <tbody ng-repeat="(date, items) in data.items">
            <tr ng-if="data.remainders[date]">
                <td colspan="4">
                    <span ng-show="!items.length">@{{ date | date:'dd.MM.yyyy' }}</span>
                </td>
                <td>@{{ data.remainders[date].sum | number }}</td>
                <td colspan="2" class="text-gray">
                    @{{ data.remainders[date].comment }}
                </td>
            </tr>
            <tr ng-if="data.totals[date]">
                <td colspan="3"></td>
                <td colspan="2">@{{ data.totals[date].sum | number }}</td>
                <td colspan="2" class="text-gray">
                    @{{ data.totals[date].comment }}
                </td>
            </tr>
            <tr ng-repeat="item in items" ng-class="{'last-date': $last}">
                <td width='120'>
                    <span ng-show="$last">@{{ date | date:'dd.MM.yyyy' }}</span>
                </td>
                <td width='120'>
                    <span ng-show="item.addressee_id == source_id" class="text-green">+@{{ item.sum | number }}</span>
                </td>
                <td width='120'>
                    <span ng-show="item.source_id == source_id" class="text-danger">-@{{ item.sum | number }}</span>
                </td>
                <td width='120'>
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
    .text-green {
        color: #158E51 !important;
    }
</style>