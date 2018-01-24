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