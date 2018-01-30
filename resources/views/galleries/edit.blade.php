@extends('app')
@section('title', 'Редактирование фото')
@section('title-center')
    <span ng-click="edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить фото</span>
@stop
@section('content')
@section('controller', 'GalleryForm')
<div class="row">
    <div class="col-sm-12">
        @include('galleries._form')
    </div>
</div>
@stop
