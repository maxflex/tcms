@extends('app')
@section('title', 'Видео')
@section('controller', 'VideosIndex')

@section('title-right')
    @include('modules.folder-controls')
    {{ link_to_route('videos.create', 'добавить видео') }}
@endsection

@section('content')
    @include('modules.folders')
    <table class="table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                @include('videos._item')
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
