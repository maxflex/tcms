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
                <a href='reviews/@{{ model.id }}/edit'>@{{ model.signature }}</a>
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
            <td width='100'>
                <a href='reviews/@{{ model.id }}/edit'>редактировать</a>
            </td>
            <td width='100' style='text-align: right'>
                <a class="pointer" ng-click="IndexService.delete(model.id, 'отзыв')">удалить</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
