@extends('app')
@section('title', 'Отзывы')
@section('controller', 'ReviewsIndex')

@section('title-right')
    @include('modules.folder-controls')
    {{ link_to_route('reviews.create', 'добавить отзыв') }}
@endsection

@section('content')
    @include('modules.folders')
    <table class="table">
        <tbody ui-sortable='FolderService.itemSortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                @include('reviews._item')
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
