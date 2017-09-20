@extends('app')
@section('title', 'Прайс лист')
@section('controller', 'PricesIndex')

@section('title-right')
    {{ link_to_route('prices.create', '+ раздел') }}
@endsection

@section('content')
    <div class="price-list">
        <ul>
            <li ng-repeat="model in IndexService.page.data">
                <price-item item='model'></price-item>
            </li>
        </ul>
    </div>
    @include('modules.pagination')
    @include('prices._modals')
@stop
