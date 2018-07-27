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
                <td>
                    <a href='reviews/@{{ model.id }}/edit'>@{{ model.signature || 'не указано' }}</a>
                </td>
                <td>
                    @{{ model.date }}
                </td>
                <td>
                    оценка @{{ model.score || 'не установлена' }}
                </td>
                <td>
                    @{{ model.published ? 'опубликован' : 'не опубликован' }}
                </td>
                <td>
                    <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
                </td>
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
