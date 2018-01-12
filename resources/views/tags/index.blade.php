@extends('app')
@section('title', 'Теги')
@section('controller', 'TagsIndex')

@section('title-right')
    {{ link_to_route('tags.create', 'добавить тег') }}
@endsection

@section('content')
    <table class="table">
        <tbody ui-sortable='sortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                <td>
                    <a href='tags/@{{ model.id }}/edit'>@{{ model.text || 'имя не указано' }}</a>
                </td>
                <td width='100' style='text-align: right'>
                    <a href='tags/@{{ model.id }}/edit'>редактировать</a>
                </td>
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop
