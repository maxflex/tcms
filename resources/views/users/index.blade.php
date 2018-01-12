@extends('app')
@section('title', 'Пользователи')
@section('controller', 'UsersIndex')

@section('title-right')
    {{ link_to_route('users.create', 'добавить пользователя') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='users/@{{ model.id }}/edit'>@{{ model.login || 'имя не указано' }}</a>
            </td>
            <td>
                @{{ model.last_name }}
                @{{ model.first_name }}
                @{{ model.middle_name }}
            </td>
            <td width='100'>
                <a href='users/@{{ model.id }}/edit'>редактировать</a>
            </td>
            <td width='100' style='text-align: right'>
                <a class="pointer" ng-click="IndexService.delete(model.id, 'пользователя')">удалить</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
