@extends('app')
@section('title', 'Галлерея')
@section('controller', 'GalleryIndex')

@section('title-right')
    @include('modules.folder-controls')
    <a class="pointer" ng-click="changePriceDialog()">индексация</a>
    <a href="{{ route('galleries.create', request()->has('folder') ? ['folder' => request()->input('folder')] : []) }}">добавить фото</a>
@endsection

@section('content')
    @include('modules.folders')
    <table class="table vertical-align-table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                @include('galleries._item')
            </tr>
        </tbody>
    </table>
@stop

@include('galleries._modals')
