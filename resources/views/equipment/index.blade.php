@extends('app')
@section('title', 'Оборудование')
@section('controller', 'EquipmentIndex')

@section('title-right')
    <span ng-click="FolderService.createModal()">создать папку</span>
    {{ link_to_route('equipment.create', 'добавить оборудование') }}
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
                    <a href='@{{ template.table }}/@{{ model.id }}/edit'>@{{ model.name || 'имя не указано' }}</a>
                </td>
                <td>
                    <img class="inline-photo" ng-show='model.photos.length && model.photos[0].cropped' src='@{{ model.photos[0].cropped_url}}'>
                    <img class="inline-photo" ng-show='!model.photos.length || !model.photos[0].cropped' src='/img/icons/nocropped.png'>
                </td>
                <td width='100' style='text-align: right'>
                    <a href='@{{ template.table }}/@{{ model.id }}/edit'>редактировать</a>
                </td>
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
    @include('modules.folders')
@stop
