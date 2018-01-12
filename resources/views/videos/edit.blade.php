@extends('app')
@section('title', 'Редактирование видео')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить видео</a>
@stop
@section('content')
@section('controller', 'VideosForm')
<div class="row">
    <div class="col-sm-12">
        @include('videos._form')
    </div>
</div>
@stop
