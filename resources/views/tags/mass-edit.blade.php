@extends('app')
@section('title', 'Массовое редактирование тега: ' . $tag->text)
@section('controller', 'TagsMassEdit')

@section('content')
    <div>
        <div ng-repeat="item in items">
            <{{ $directive }} model="item" level="0"></{{ $directive }}>
        </div>
    </div>
@stop
