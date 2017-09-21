@extends('app')
@section('title', 'Галлерея')
@section('controller', 'GalleryIndex')

@section('title-right')
    {{ link_to_route('gallery.create', 'добавить фото') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                @{{ model.id }}
            </td>
            <td>
                @{{ model.name }}
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
                <a href='gallery/@{{ model.id }}/edit'>редактировать</a>
            </td>
            <td width='100' style='text-align: right'>
                <a class="pointer" ng-click="IndexService.delete(model.id, 'фото')">удалить</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
<style>
    .table tr td {
        vertical-align: middle !important;
    }
</style>
