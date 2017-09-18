@extends('app')
@section('title', 'Прайс лист')
@section('controller', 'PricesIndex')

@section('content')
    <div class="price-list">
        <ul>
            <li ng-repeat="model in IndexService.page.data">
                <price-item item='model'></price-item>
            </li>
            <li>
                {{ link_to_route('prices.create', 'добавить раздел') }}
            </li>
        </ul>
    </div>
    @include('modules.pagination')
    @include('prices._modals')
@stop
