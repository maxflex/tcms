@extends('app')
@section('title', 'Теги')
@section('controller', 'TagsIndex')

@section('title-right')
    {{ link_to_route('tags.create', 'добавить тег') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                <a href='tags/@{{ model.id }}/edit'>@{{ model.text }}</a>
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
