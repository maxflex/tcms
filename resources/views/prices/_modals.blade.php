<!-- Modal -->
<div id="change-price-modal" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <div class="row">
              <div class="col-sm-4">
                  <select class='selectpicker' ng-model='change_price.type'>
                      <option value='1' selected>понизить</option>
                      <option value='2' selected>повысить</option>
                  </select>
              </div>
              <div class="col-sm-4">
                  <input ng-model='change_price.value' class="form-control" placeholder="@{{ change_price.type == 1 ? 'понизить' : 'повысить' }} на @{{ change_price.unit == 1 ? '%' : 'руб.' }}" />
              </div>
              <div class="col-sm-4">
                  <select class='selectpicker' ng-model='change_price.unit'>
                      <option value='1' selected>%</option>
                      <option value='2' selected>руб.</option>
                  </select>
              </div>
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-disabled="changing_price" type="button" class="btn btn-primary" ng-click="changePrice()">@{{ change_price.type == 1 ? 'понизить' : 'повысить' }}</button>
      </div>
    </div>
  </div>
</div>
