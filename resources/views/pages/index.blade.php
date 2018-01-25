@extends('app')
@section('title', 'Страницы')
@section('controller', 'PagesIndex')

@section('title-right')
    <span ng-click='ExportService.exportDialog()'>экспорт</span>
    {{-- {{ link_to_route('pages.import', 'импорт', [], ['ng-click'=>'ExportService.import($event)']) }} --}}
    <span ng-click="FolderService.createModal()">создать папку</span>
    {{ link_to_route('pages.create', 'добавить страницу') }}
@endsection

@section('content')
    <table class="table" style='margin: 0' ng-show='true'>
        <tbody ui-sortable='FolderService.sortableOptions' ng-model="FolderService.folders">
            <tr ng-if='folder'>
                <td colspan='4'>
                    <i class="fa fa-long-arrow-left text-success" aria-hidden="true" style='margin-right: 3px'></i>
                    <a class="pointer" onclick="window.history.back()">назад</a>
                </td>
            </tr>
            <tr ng-repeat="folder in FolderService.folders">
                <td width='10'>
                    @{{ folder.id }}
                </td>
                <td>
                    <i class="fa fa-folder text-success" aria-hidden="true" style='margin-right: 5px'></i>
                    <a href="@{{ template.table }}?folder=@{{ folder.id }}">@{{ folder.name }}</a>
                </td>
                <td width='100'>
                    <a class="pointer" ng-click="FolderService.editModal(folder)">редактировать</a>
                </td>
                <td width='100' style='text-align: right'>
                    <a class="pointer" ng-click="FolderService.delete(folder)">удалить</a>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table vertical-align-table">
        <tbody ui-sortable='sortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                <td width='10'>
                    @{{ model.id }}
                </td>
                <td width='500'>
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
    @include('modules.pagination')
    @include('modules.folders')
@stop
