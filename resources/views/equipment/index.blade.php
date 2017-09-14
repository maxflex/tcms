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
        </tr>
    </table>
    @include('modules.pagination')
@stop
