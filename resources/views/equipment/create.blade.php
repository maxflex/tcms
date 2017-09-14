@extends('app')
@section('controller', 'EquipmentForm')
@section('title', 'Добавление оборудования')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('equipment._form')
        @include('modules.create_button')
    </div>
</div>
@stop
