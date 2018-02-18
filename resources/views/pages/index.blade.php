@extends('app')
@section('title', 'Страницы')
@section('controller', 'PagesIndex')

@section('title-right')
    @include('modules.folder-controls')
    {{ link_to_route('pages.create', 'добавить страницу') }}
@endsection

@section('content')
    @include('modules.folders')
    <table class="table vertical-align-table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                <td width='10'>
                    @{{ model.id }}
                </td>
                <td width='484'>
                    <a href='@{{ template.table }}/@{{ model.id }}/edit'>@{{ model.keyphrase || 'имя не указано' }}</a>
                </td>
                <td>
                    <span class="link-like" ng-class="{'link-gray': 0 == +page.published}" ng-click="toggleEnumServer(page, 'published', Published, Page)">@{{ Published[model.published].title }}</span>
                </td>
                <td>
                    @{{ formatDateTime(model.updated_at) }}
                </td>
                <td width='250' style='text-align: right'>
                    <a href="{{ config('app.web-url') }}@{{ model.url }}" target="_blank">просмотреть страницу на сайте</a>
                </td>
            </tr>
        </tbody>
    </table>
@stop
