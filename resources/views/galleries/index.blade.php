@extends('app')
@section('title', 'Галлерея')
@section('controller', 'GalleryIndex')

@section('title-right')
    @include('modules.folder-controls')
    <a class="pointer" ng-click="changePriceDialog()">индексация</a>
    {{ link_to_route('galleries.create', 'добавить фото') }}
@endsection

@section('content')
    @include('modules.folders')
    <table class="table vertical-align-table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="gallery in IndexService.page.data">
                @include('galleries._item')
            </tr>
        </tbody>
    </table>
@stop

@include('galleries._modals')
