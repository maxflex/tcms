@extends('app')
@section('title', 'Галлерея')
@section('controller', 'GalleryIndex')

@section('title-right')
    {{ link_to_route('gallery.create', 'добавить фото') }}
@endsection

@section('content')
    <table class="table">
        <tr ng-repeat="model in IndexService.page.data">
            <td>
                @{{ model.id }}
            </td>
            <td>
                @{{ model.name }}
            </td>
            <td>
                <img src='@{{ model.photos[0].cropped_url }}' style='height: 50px' />
            </td>
            <td>
                @{{ model.id }}
            </td>
            <td>
                @{{ model.id }}
            </td>
        </tr>
    </table>
    @include('modules.pagination')
@stop
<style>
    .table tr td {
        vertical-align: middle !important;
    }
</style>
