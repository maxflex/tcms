<table class="table" style='margin: 0'>
    <tbody ui-sortable='FolderService.folderSortableOptions' ng-model="FolderService.folders">
        <tr ng-if='folder'>
            <td colspan='4'>
                <i class="fa fa-long-arrow-left text-success" aria-hidden="true" style='margin-right: 3px'></i>
                <a class="pointer" onclick="window.history.back()">назад</a>
            </td>
        </tr>
        <tr ng-repeat="folder in FolderService.folders">
            <td width='10'>
                @{{ folder.id }}
            </td>
            <td width='500'>
                <i class="fa fa-folder text-success" aria-hidden="true" style='margin-right: 5px'></i>
                <a href="@{{ template.table }}?folder=@{{ folder.id }}">@{{ folder.name }}</a>
            </td>
            <td>
                <span ng-show="!FolderService.isEmpty(folder)">
                    <plural count="folder.item_count" type='file' hide-zero></plural><span ng-show="folder.item_count && folder.folder_count">, </span>
                    <plural count="folder.folder_count" type='folder' hide-zero></plural>
                </span>
                <span ng-show="FolderService.isEmpty(folder)" class="quater-black">пусто</span>
            </td>
            <td width='100'>
                <a class="pointer" ng-click="FolderService.editModal(folder)">редактировать</a>
            </td>
            <td width='100' style='text-align: right'>
                <a class="pointer" ng-click="FolderService.delete(folder)">удалить</a>
            </td>
        </tr>
    </tbody>
</table>
<!-- Modal -->
<div id="folder-modal" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">@{{ FolderService.popup_folder.id ? 'Редактирование' : 'Создание' }} папки</h4>
    </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-sm-12">
                  <input class='form-control' ng-model='FolderService.popup_folder.name' placeholder="новая папка">
              </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-disabled="!FolderService.popup_folder.name" type="button" class="btn btn-primary" ng-click="FolderService.createOrUpdate()">@{{ FolderService.popup_folder.id ? 'изменить' : 'создать папку' }}</button>
      </div>
    </div>
  </div>
</div>