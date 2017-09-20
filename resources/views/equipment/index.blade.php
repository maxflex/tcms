@extends('app')
@section('title', 'Оборудование')
@section('controller', 'EquipmentIndex')

@section('title-right')
    {{ link_to_route('equipment.create', 'добавить оборудование') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='equipment/@{{ model.id }}/edit'>@{{ model.name }}</a>
            </td>
            <td width='100'>
                <a href='equipment/@{{ model.id }}/edit'>редактировать</a>
            </td>
            <td width='100' style='text-align: right'>
                <a class="pointer" ng-click="IndexService.delete(model.id, 'оборудование')">удалить</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
