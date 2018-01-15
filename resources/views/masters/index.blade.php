@extends('app')
@section('title', 'Мастера')
@section('controller', 'MastersIndex')

@section('title-right')
    {{ link_to_route('masters.create', 'добавить мастера') }}
@endsection

@section('content')
    <table class="table vertical-align-table">
        <tr ng-repeat="model in IndexService.page.data">
            <td width='10'>
                @{{ model.id }}
            </td>
            <td width='200'>
                <a href='masters/@{{ model.id }}/edit'>
                     @{{ (model.last_name || model.first_name || model.middle_name) ? (model.last_name + ' ' + model.first_name[0] + '. ' + model.middle_name[0] + '.') : 'имя не указано' }}
                </a>
            </td>
            <td>
                <img class="inline-photo circle" ng-show='model.photos.length && model.photos[0].cropped' src='@{{ model.photos[0].cropped_url}}'>
                <img class="inline-photo circle" ng-show='!model.photos.length || !model.photos[0].cropped' src='/img/icons/nocropped.png'>
            </td>
            <td width='100' style='text-align: right'>
                <a href='masters/@{{ model.id }}/edit'>редактировать</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
