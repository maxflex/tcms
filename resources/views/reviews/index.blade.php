@extends('app')
@section('title', 'Отзывы')
@section('controller', 'ReviewsIndex')

@section('title-right')
    {{ link_to_route('reviews.create', 'добавить отзыв') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='reviews/@{{ model.id }}/edit'>@{{ model.signature || 'не указано' }}</a>
            </td>
            <td>
                <span class="tag" ng-repeat="tag in model.tags">@{{ tag.text }}</span>
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
            <td width='100' style='text-align: right'>
                <a href='reviews/@{{ model.id }}/edit'>редактировать</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
