@extends('app')
@section('title', 'Редактирование тега')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить пользователя</a>
@stop
@section('content')
@section('controller', 'UsersForm')
<div class="row">
    <div class="col-sm-12">
        @include('users._form')
    </div>
</div>
@stop
