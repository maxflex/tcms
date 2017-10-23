<!-- Modal -->
<div id="new-folder" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Создать папку</h4>
    </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-sm-12">
                  <input class='form-control' ng-model='new_folder_name' placeholder="новая папка">
              </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-disabled="!new_folder_name" type="button" class="btn btn-primary" ng-click="createNewFolder()">создать папку</button>
      </div>
    </div>
  </div>
</div>
