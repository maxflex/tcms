@extends('app')
@section('title', 'Заголовок')
@section('controller', 'HeaderIndex')

@section('title-center')
    <span ng-click="save()">сохранить</span>
@stop

@section('content')
    <div class="row mbs">
        <div class="col-sm-12">
            <div class="field-container">
              <textarea rows="5" class="field form-control" placeholder="заголовок" ng-model="header" required
                ng-model-options="{ allowInvalid: true }" type="text">
                </textarea>
                <label class="floating-label">заголовок</label>
            </div>
        </div>
    </div>
@stop
