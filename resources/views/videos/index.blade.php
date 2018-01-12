@extends('app')
@section('title', 'Видео')
@section('controller', 'VideosIndex')

@section('title-right')
    {{ link_to_route('videos.create', 'добавить видео') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='videos/@{{ model.id }}/edit'>@{{ model.title }}</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
