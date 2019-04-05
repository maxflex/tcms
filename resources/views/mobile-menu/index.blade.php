@extends('app')
@section('title', 'Мобильное меню')
@section('controller', 'MobileMenuIndex')

@section('title-center')
    <span ng-click="save()">сохранить</span>
@stop

@section('title-right')
    <a class="pointer" ng-click="openDialog({}, 'menu-section-dialog')">добавить раздел</a>
@endsection

@section('content')
    <div class="frontend-loading animate-fadeIn" ng-if='sections === null'>
        <span>загрузка...</span>
    </div>

    <div ui-sortable='sortableOptionsSections' ng-model="sections">
        <div ng-repeat="section in sections" class='mobile-menu-section' ng-class="{'no-border-bottom': $last}">
            <h4 class='flex-items-center'>
                @{{ section.title }}
                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px; font-weight: normal'
                    ng-click="openDialog(section, 'menu-section-dialog')">изменить</a>

                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px; font-weight: normal'
                    ng-click='removeSection(section.id)'>удалить</a>
            </h4>
            <div class="mobile-menu">
                <ul ui-sortable='sortableOptions' ng-model="section.items">
                    <li ng-repeat="menu in section.items" class='menu-item'>
                        <mobile-menu-item item='menu'></mobile-menu-item>
                    </li>
                    <li>
                        <a ng-click='openDialog({section_id: section.id})' class='pointer table-small'>добавить</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @include('mobile-menu._modals')
@stop
