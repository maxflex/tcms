@extends('app')
@section('title', 'Логи')
@section('controller', 'LogsIndex')

@section('title-right')
    <span class='ng-hide' ng-show='data !== undefined'>всего результатов: @{{ data.total }}</span>
@endsection

@section('content')

<div class="row flex-list">
    <div>
        <select ng-model='search.user_id' class='selectpicker' ng-change='filter()'>
            <option value="" data-subtext="@{{ counts.type[''] || '' }}">пользователь</option>
            <option disabled>──────────────</option>
            <option ng-repeat='user in Users.active' value="@{{user.id}}">@{{ user.login }}</option>
            <option disabled ng-show="Users.banned.length">──────────────</option>
            <option ng-repeat='user in Users.banned' value="@{{user.id}}">@{{ user.login }}</option>
        </select>
    </div>
    <div>
        <select ng-model='search.type' class='selectpicker' ng-change='filter()'>
            <option value="" data-subtext="@{{ counts.type[''] || '' }}">тип действия</option>
            <option disabled>──────────────</option>
            <option ng-repeat='(id, name) in LogTypes'
                data-subtext="@{{ counts.type[id] || '' }}"
                value="@{{id}}">@{{ name }}</option>
        </select>
    </div>
    <div>
        <select ng-model='search.table' class='selectpicker' ng-change='filter()'>
            <option value="" data-subtext="@{{ counts.table[''] || '' }}">таблица</option>
            <option disabled>──────────────</option>
            <option ng-repeat='(table, data) in tables'
                data-subtext="@{{ counts.table[table] || '' }}"
                value="@{{table}}">@{{ table }}</option>
        </select>
    </div>
    <div>
        <select ng-disabled='!search.table' ng-model='search.column' class='selectpicker' ng-change='filter()'>
            <option value="" data-subtext="@{{ counts.column[''] || '' }}">ячейка</option>
            <option disabled>──────────────</option>
            <option ng-repeat='column in tables[search.table]'
                data-subtext="@{{ counts.column[column] || '' }}"
                value="@{{column}}">@{{ column }}</option>
        </select>
    </div>
    <div>
        <div class="form-group">
            <div class="input-group custom">
              <span class="input-group-addon">ID –</span>
              <input type="text" ng-keyup='keyFilter($event)' class="form-control" ng-model="search.row_id">
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <table class="table reverse-borders" style="font-size: 12px">
            <thead>
                <td></td>
                <td></td>
                <td></td>
            </thead>
            <tbody>
                <tr ng-repeat='log in logs'>
                    <td>
                        @{{ log.table }}
                    </td>
                    <td>
                        @{{ LogTypes[log.type] || log.type }}
                    </td>
                    <td>
                        <a target="_blank" ng-href="@{{ log.link }}" ng-show="log.link">@{{ log.row_id }}</a>
                        <span ng-show="!log.link">@{{ log.row_id }}</span>
                    </td>
                    <td width="100">
                        @{{ log.user.login }}
                    </td>
                    <td ng-init='d = toJson(log.data)'>
                        <table style="font-size: 12px">
                            <tr ng-repeat="(key, data) in d track by $index">
                                <td style="vertical-align: top; width: 150px">@{{ key }}</td>
                                <td class="text-gray">
                                    <span ng-if="log.row_id">
                                        <span>@{{ data[0]  }}</span>
                                        <span>⟶</span>
                                        <span style='color: black'>@{{ data[1] }}</span>
                                    </span>
                                    <span ng-if="!log.row_id">
                                        @{{ data }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                        {{-- <div ng-repeat="(key, data) in d track by $index" class="log-info">
                            <span>@{{ key }}</span>
                            <span class="text-gray">@{{ data[0] }}</span>
                            <span class='text-gray'>⟶</span>
                            <span>@{{ data[1] }}</span>
                        </div> --}}
                    </td>
                    <td>
                        <span style="white-space: nowrap">@{{ formatDateTime(log.created_at) }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@include('modules.pagination')
@stop
