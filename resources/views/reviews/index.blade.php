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
        </tr>
    </table>
    @include('modules.pagination')
@stop
