@extends('app')
@section('title', 'Редактирование фото')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="preview()">предпросмотр</span>
    <span ng-click="FormService.delete($event)">удалить фото</span>
@stop
@section('content')
@section('controller', 'GalleryForm')
<div class="row">
    <div class="col-sm-12">
        @include('gallery._form')
    </div>
</div>
@stop
