@extends('app')
@section('title', 'Редактирование оборудования')
@section('title-center')
    <span ng-click="FormService.edit()">сохранить</span>
@stop
@section('title-right')
    <span ng-click="FormService.delete($event)">удалить оборудование</a>
@stop
@section('content')
@section('controller', 'EquipmentForm')
<div class="row">
    <div class="col-sm-12">
        @include('equipment._form')
    </div>
</div>
@stop
