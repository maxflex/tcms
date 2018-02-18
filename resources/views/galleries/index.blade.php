@extends('app')
@section('title', 'Галлерея')
@section('controller', 'GalleryIndex')

@section('title-right')
    @include('modules.folder-controls')
    {{ link_to_route('galleries.create', 'добавить фото') }}
@endsection

@section('content')
    @include('modules.folders')
    <table class="table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                <td width='10'>
                    @{{ model.id }}
                </td>
                <td>
                    @{{ model.name || 'имя не указано' }}
                </td>
                <td>
                    <img ng-show='model.has_photo' src='/img/gallery/@{{model.id}}.jpg' style='height: 50px'>
                    <div ng-show='!model.has_photo' class="no-photo-small">нет фото</div>
                </td>
                <td>
                    @{{ model.image_size }}
                </td>
                <td>
                    @{{ model.file_size }}
                </td>
                <td width='100'>
                    <a href='@{{ template.table }}/@{{ model.id }}/edit'>редактировать</a>
                </td>
                <td width='100' style='text-align: right'>
                    <a class="pointer" ng-click="IndexService.delete(model.id, 'фото')">удалить</a>
                </td>
            </tr>
        </tbody>
    </table>
@stop

<style>
    .table tr td {
        vertical-align: middle !important;
    }
</style>
