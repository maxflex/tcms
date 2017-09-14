@extends('app')
@section('title', 'Редактирование мастера')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить мастера</a>
@stop
@section('content')
@section('controller', 'MastersForm')
<div class="row">
    <div class="col-sm-12">
        @include('masters._form')
    </div>
</div>
@stop
