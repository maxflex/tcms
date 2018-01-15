@extends('app')
@section('title', 'Оборудование')
@section('controller', 'EquipmentIndex')

@section('title-right')
    {{ link_to_route('equipment.create', 'добавить оборудование') }}
@endsection

@section('content')
    <table class="table vertical-align-table">
        <tr ng-repeat="model in IndexService.page.data">
            <td width='10'>
                @{{ model.id }}
            </td>
            <td width='500'>
                <a href='equipment/@{{ model.id }}/edit'>@{{ model.name || 'имя не указано' }}</a>
            </td>
            <td>
                <img class="inline-photo" ng-show='model.photos.length && model.photos[0].cropped' src='@{{ model.photos[0].cropped_url}}'>
                <img class="inline-photo" ng-show='!model.photos.length || !model.photos[0].cropped' src='/img/icons/nocropped.png'>
            </td>
            <td width='100' style='text-align: right'>
                <a href='equipment/@{{ model.id }}/edit'>редактировать</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
