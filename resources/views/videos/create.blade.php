@extends('app')
@section('controller', 'VideosForm')
@section('title', 'Добавление видео')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('videos._form')
        @include('modules.create_button')
    </div>
</div>
@stop
