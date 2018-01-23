@extends('app')
@section('title', 'Прайс лист')
@section('controller', 'PricesIndex')

@section('title-right')
    {{ link_to_route('prices.create', '+ раздел') }}
    <a class="pointer" ng-click="changePriceRootDialog()">индексация</a>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
    <div class="price-list">
        <ul ui-sortable='sortableOptions' ng-model="items">
            <li ng-repeat="item in items" class='price-item-@{{ $parent.$id }}'>
                <price-item item='item'></price-item>
            </li>
        </ul>
    </div>
    @include('prices._modals')
@stop
