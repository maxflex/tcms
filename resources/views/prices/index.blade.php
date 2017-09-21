@extends('app')
@section('title', 'Прайс лист')
@section('controller', 'PricesIndex')

@section('title-right')
    {{ link_to_route('prices.create', '+ раздел') }}
@endsection

@section('content')
    <div class="price-list">
        <ul ui-sortable='sortableOptions' ng-model="items">
            <li ng-repeat="item in items" class='price-item-@{{ $parent.$id }}'>
                <price-item item='item'></price-item>
            </li>
        </ul>
    </div>
    @include('prices._modals')
@stop
