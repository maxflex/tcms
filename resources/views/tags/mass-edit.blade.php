@extends('app')
@section('title', 'Пакетное редактирование тега: ' . $tag->text)
@section('controller', 'TagsMassEdit')

@section('content')
    <div>
        <div ng-repeat="item in items">
            <{{ $directive }} model="item" level="0"></{{ $directive }}>
        </div>
    </div>
@stop
