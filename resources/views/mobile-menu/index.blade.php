@extends('app')
@section('title', ($type === 'mobile' ? 'Мобильное меню' : 'Стационарное меню'))
@section('controller', 'MobileMenuIndex')

@section('title-right')
    <a class="pointer" ng-click="openDialog({}, 'menu-section-dialog')">добавить раздел</a>
@endsection

@section('content')
    <span ng-init="type = '{{ $type }}'"></span>
    <div class="frontend-loading animate-fadeIn" ng-if='sections === null'>
        <span>загрузка...</span>
    </div>

    <div ui-sortable='sortableOptionsSections' ng-model="sections">
        <div ng-repeat="section in sections" class='mobile-menu-section' ng-class="{'no-border-bottom': $last}">
            <h4 class='flex-items-center'>
                <a class="pointer" style='margin-right: 5px; font-size: 14px'>
                    <i class="pointer fa"
                        ng-class="{
                            'fa-plus': isCollapsedSection(section),
                            'fa-minus': !isCollapsedSection(section)
                        }"
                        ng-click="toggleCollapseSection(section)"
                        aria-hidden="true"
                    ></i>
                </a>
                <a class='menu-title'
                    ng-class="{'menu-title_hidden': section.is_hidden}"
                    ng-if="section.is_link"
                    href="{{ config('app.web-url') }}@{{ section.extra }}" href="_blank"
                >
                    @{{ section.title }}
                </a>
                <span
                    class='menu-title'
                    ng-class="{'menu-title_hidden': section.is_hidden}"
                    ng-if="!section.is_link"
                >
                    @{{ section.title }}
                </span>
                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px; font-weight: normal'
                    ng-click='openDialog({section_id: section.id})'>добавить</a>
                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px; font-weight: normal'
                    ng-click="openDialog(section, 'menu-section-dialog')">изменить</a>

                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px; font-weight: normal'
                    ng-click='removeSection(section.id)'>удалить</a>

                <a class='pointer table-small show-on-hover'
                    style='margin-left: 8px; font-weight: normal'
                    ng-click='hideSection(section)'>
                    @{{ section.is_hidden ? 'показать' : 'скрыть' }}
                </a>
            </h4>
            <div class="mobile-menu" ng-hide="isCollapsedSection(section)">
                <ul ui-sortable='sortableOptions' ng-model="section.items">
                    <li ng-repeat="menu in section.items" class='menu-item'>
                        <mobile-menu-item item='menu'></mobile-menu-item>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @include('mobile-menu._modals')
@stop
