@extends('app')
@section('controller', 'GalleryForm')
@section('title', 'Добавление фото')
@section('content')
<div class="row">
    <div class="col-sm-12">
        @include('gallery._form')
        @include('modules.create_button')
    </div>
</div>
@stop
