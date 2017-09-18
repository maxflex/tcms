@extends('app')
@section('controller', 'PricePositionForm')
@section('title', "Добавление позиции к разделу «{$section_name}»")
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('prices.positions._form')
        @include('modules.create_button')
    </div>
</div>
@stop
