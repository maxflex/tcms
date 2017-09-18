@extends('app')
@section('title', 'Редактирование раздела')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить раздел</a>
@stop
@section('content')
@section('controller', 'PricesForm')
<div class="row">
    <div class="col-sm-12">
        @include('prices._form')
    </div>
</div>
@stop
