@extends('app')
@section('title', 'Редактирование отзыва')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить отзыв</a>
@stop
@section('content')
@section('controller', 'ReviewsForm')
<div class="row">
    <div class="col-sm-12">
        @include('reviews._form')
    </div>
</div>
@stop
