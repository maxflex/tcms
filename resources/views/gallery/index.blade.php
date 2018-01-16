@extends('app')
@section('title', 'Галлерея')
@section('controller', 'GalleryIndex')

@section('title-right')
    {{ link_to_route('gallery.create', 'добавить фото') }}
@endsection

@section('content')
    <table class="table" style='margin: 0' ng-show='!folder_id'>
        <tbody ui-sortable='sortableOptionsFolder' ng-model="folders">
            <tr ng-repeat="folder in folders">
                <td width='10'>
                    @{{ folder.id }}
                </td>
                <td>
                    <i class="fa fa-folder text-success" aria-hidden="true" style='margin-right: 5px'></i>
                    <a href="/gallery/folder/@{{ folder.id }}">@{{ folder.name }}</a>
                </td>
                <td width='100'>
                    <a class="pointer" ng-click="editFolderPopup(folder)">редактировать</a>
                </td>
                <td width='100' style='text-align: right'>
                    <a class="pointer" ng-click="deleteFolder(folder)">удалить</a>
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table" style='margin: 0' ng-show='folder_id'>
            <tr>
                <td>
                    <i class="fa fa-long-arrow-left text-success" aria-hidden="true" style='margin-right: 3px'></i>
                    <a href="/gallery">назад</a>
                </td>
            </tr>
    </table>
    <table class="table">
        <tbody ui-sortable='sortableOptions' ng-model="IndexService.page.data">
            <tr ng-repeat="model in IndexService.page.data">
                <td width='10'>
                    @{{ model.id }}
                </td>
                <td>
                    @{{ model.name }}
                </td>
                <td>
                    <img ng-show='model.has_photo' src='/img/gallery/@{{model.id}}.jpg' style='height: 50px'>
                    <div ng-show='!model.has_photo' class="no-photo-small">нет фото</div>
                </td>
                <td>
                    @{{ model.image_size }}
                </td>
                <td>
                    @{{ model.file_size }}
                </td>
                <td width='100'>
                    <a href='gallery/@{{ model.id }}/edit'>редактировать</a>
                </td>
                <td width='100' style='text-align: right'>
                    <a class="pointer" ng-click="IndexService.delete(model.id, 'фото')">удалить</a>
                </td>
            </tr>
        </tbody>
    </table>
    @include('modules.pagination')
@stop

<!-- Modal -->
<div id="edit-folder" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Редактировать папку</h4>
    </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-sm-12">
                  <input class='form-control' ng-model='popup_folder_name' placeholder="новая папка">
              </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-disabled="!popup_folder_name" type="button" class="btn btn-primary" ng-click="editFolder()">редактировать</button>
      </div>
    </div>
  </div>
</div>

<style>
    .table tr td {
        vertical-align: middle !important;
    }
</style>
