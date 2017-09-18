@extends('app')
@section('controller', 'PricesForm')
@section('title', 'Добавление раздела')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('prices._form')
        @include('modules.create_button')
    </div>
</div>
@stop
