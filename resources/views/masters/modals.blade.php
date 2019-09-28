<!-- Modal -->
<div id="change-master-dialog" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog" style='width: 300px'>
    <div class="modal-content">
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 mbs">
                <label class="no-margin-bottom label-opacity">мастер</label>
                <ng-select-new model='changeMasterId' object="masters" label="name" convert-to-number none-text='выберите мастера'></ng-select-new>
            </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-disabled='!changeMasterId' type="button" class="btn btn-primary" ng-click="changeReviewMaster()">
            изменить мастера
        </button>
      </div>
    </div>
  </div>
</div>
