@extends('app')
@section('controller', 'MastersForm')
@section('title', 'Добавление мастера')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('masters._form')
        @include('modules.create_button')
    </div>
</div>
@stop
