<!-- Modal -->
<div id="menu-item-dialog" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog" style='width: 300px'>
    <div class="modal-content">
      <div class="modal-body">
          <div class="row">
              <div class="col-sm-12 mbs">
                <input type="checkbox" id="is-link" name="is-link" ng-model="dialogItem.is_link" ng-checked="dialogItem.is_link" ng-true-value='1' ng-false-value='0'>
                <label for="is-link" style='padding-left: 5px'>ссылка</label>
              </div>
              <div class="col-sm-12 mbs">
                <input ng-model='dialogItem.title' class="form-control" placeholder="заголовок" />
              </div>
              <div class="col-sm-12">
                  <input ng-model='dialogItem.extra' class="form-control" placeholder="@{{ dialogItem.is_link ? 'адрес ссылки' : 'описание' }}" />
              </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button type="button" class="btn btn-primary" ng-click="save()">
            @{{ dialogItem.id ? 'изменить' : 'добавить' }}
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="menu-section-dialog" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog" style='width: 300px'>
    <div class="modal-content">
      <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 mbs" ng-if="type === 'desktop'">
                <input type="checkbox" id="is-link" name="is-link" ng-model="dialogItem.is_link" ng-checked="dialogItem.is_link" ng-true-value='1' ng-false-value='0'>
                <label for="is-link" style='padding-left: 5px'>ссылка</label>
            </div>
            <div class="col-sm-12 mbs">
                <input ng-model='dialogItem.title' class="form-control" placeholder="название раздела" />
            </div>
            <div class="col-sm-12" ng-if="dialogItem.is_link">
                  <input ng-model='dialogItem.extra' class="form-control" placeholder="адрес ссылки" />
              </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button type="button" class="btn btn-primary" ng-click="saveSection()">
            @{{ dialogItem.id ? 'изменить' : 'добавить' }}
        </button>
      </div>
    </div>
  </div>
</div>

