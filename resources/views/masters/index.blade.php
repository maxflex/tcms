@extends('app')
@section('title', 'Мастера')
@section('controller', 'MastersIndex')

@section('title-right')
    {{ link_to_route('masters.create', 'добавить мастера') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='masters/@{{ model.id }}/edit'>
                  @{{ model.last_name }} @{{ model.first_name[0] }}. @{{ model.middle_name[0] }}.
                </a>
            </td>
            <td width='100' style='text-align: right'>
                <a href='masters/@{{ model.id }}/edit'>редактировать</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
