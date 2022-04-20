@extends('app')
@section('title', 'Прайс-лист')
@section('controller', 'PricesIndex')

@section('title-custom')
    <a class="pointer" ng-click="changePriceRootDialog()">индексация</a>
    @if (request()->has('id'))
    <a href="{{ route('prices.edit', ['price' => request()->input('id')]) }}">редактировать раздел</a>
    @endif
    <a href="{{ route('prices.create', request()->has('id') ? ['id' => request()->input('id')] : []) }}">добавить раздел</a>
    @if (request()->has('id'))
    <a href="{{ route('positions.create', ['id' => request()->input('id')]) }}">добавить позицию</a>
    @endif
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
    {{-- <div class="price-list">
        <ul ui-sortable='sortableOptions' ng-model="items">
            <li ng-repeat="item in items" class='price-section-@{{ item.id }}'>
                <price-section item='item'></price-section>
            </li>
        </ul>
    </div> --}}
    <table class="table" style='margin: 0'>
        <tbody>
            <tr ng-if='tree'>
                <td colspan='10'>
                    <a href="prices"><i class="fa fa-folder-open" aria-hidden="true"></i></a>
                    <span> / </span>
                    <span ng-repeat="i in tree">
                        <a ng-if="!$last" href="prices?id=@{{ i.id }}">@{{ i.name }}</a>
                        <span ng-if="$last">@{{ i.name }}</span>
                        <span ng-show="!$last"> / </span>
                    </span>
                </td>
            </tr>
        </tbody>
        <tbody ui-sortable='sortableOptionsSections' ng-model="sections">
            <tr ng-repeat="section in sections" ng-class="{'half-opacity': section.is_hidden}" class="price-section">
                <td width="10">
                    @{{ section.id }}
                </td>
                <td width="400">
                    <i class="fa fa-folder text-success" aria-hidden="true" style="margin-right: 5px"></i>
                    <a href="/prices?id=@{{ section.id}}">
                        @{{ section.name }}
                    </a>
                </td>
                <td width="200">
                    <plural count="section.sections_count" type='section' hide-zero></plural><span ng-show="section.positions_count && section.sections_count">, </span>
                    <plural count="section.positions_count" type='position' hide-zero></plural>
                </td>
                <td style='text-align: right'>
                    <a class="pointer" ng-click="hide(section)">
                        <span class="glyphicon " ng-class="{
                            'glyphicon-eye-close': section.is_hidden,
                            'glyphicon-eye-open': !section.is_hidden,
                        }"></span>
                    </a>
                </td>
            </tr>
        </tbody>
        <tbody ui-sortable='sortableOptionsPositions' ng-model="positions">
            <tr class="price-position" ng-repeat="p in positions">
                <td width="10">
                    @{{ p.id }}
                </td>
                <td>
                    <a href="/prices/positions/@{{ p.id }}/edit">
                        @{{ p.name || 'название пусто' }}
                    </a>
                </td>
                <td>
                   <span style='display: inline-block; width: 175px; font-size: 10px'>от @{{ p.price | number }} руб.<span ng-show="p.unit">/@{{ findById(Units, p.unit).title }}</span></span>
                </td>
                <td>
                    <span class="tag" ng-repeat="tag in p.tags">@{{ tag.text }}</span>
                </td>
            </tr>
        </tbody>
    </table>
    @include('prices._modals')
@stop
