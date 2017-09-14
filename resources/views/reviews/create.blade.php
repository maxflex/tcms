@extends('app')
@section('controller', 'ReviewsForm')
@section('title', 'Добавление отзыва')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('reviews._form')
        @include('modules.create_button')
    </div>
</div>
@stop
