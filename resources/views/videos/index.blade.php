@extends('app')
@section('title', 'Видео')
@section('controller', 'VideosIndex')

@section('title-right')
    {{ link_to_route('videos.create', 'добавить видео') }}
@endsection

@section('content')
    <table class="table">
        <tbody ui-sortable='sortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="video in IndexService.page.data">
                @include('videos/_item')
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
