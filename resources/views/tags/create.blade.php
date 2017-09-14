@extends('app')
@section('controller', 'TagsForm')
@section('title', 'Добавление тега')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('tags._form')
        @include('modules.create_button')
    </div>
</div>
@stop
