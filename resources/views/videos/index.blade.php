@extends('app')
@section('title', 'Видео')
@section('controller', 'VideosIndex')

@section('title-right')
    {{ link_to_route('videos.create', 'добавить видео') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td width='10'>
                @{{ model.id }}
            </td>
            <td>
                <a href='videos/@{{ model.id }}/edit'>@{{ model.title }}</a>
            </td>
            <td>
                <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
