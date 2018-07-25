@extends('app')
@section('title', 'Оборудование')
@section('controller', 'EquipmentIndex')

@section('title-right')
    @include('modules.folder-controls')
    {{ link_to_route('equipment.create', 'добавить оборудование') }}
@endsection

@section('content')
    @include('modules.folders')
    <table class="table vertical-align-table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
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
                <td>
                    <span ng-show='model.color && model.color.length == 6'>
                        <div style='display: flex; align-items: center'>
                            <span class="color-circle" ng-style="{'background': '#' + model.color}"></span>
                            <span>#@{{ model.color }}</span>
                        </div>
                    </span>
                </td>
                <td>
                    <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
                </td>
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
