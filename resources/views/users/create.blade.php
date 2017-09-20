@extends('app')
@section('controller', 'UsersForm')
@section('title', 'Добавление пользователя')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('users._form')
        @include('modules.create_button')
    </div>
</div>
@stop
