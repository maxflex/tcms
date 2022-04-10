<!-- Modal -->
<div id="change-price-modal" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          {{-- <div class="row mb">
              <div class="col-sm-12">
                  Будет <plural count="rows_affected" type="will_be_updated" text-only></plural> <b>@{{ rows_affected }}</b> <plural count="rows_affected" type="position" text-only></plural>
              </div>
          </div> --}}
          <div class="row" style='padding-top: 10px'>
              <div class="col-sm-6">
                  <select class='selectpicker' ng-model='change_price.type'>
                      <option value='1' selected>понизить</option>
                      <option value='2' selected>повысить</option>
                  </select>
              </div>
              <div class="col-sm-6">
                  <input ng-model='change_price.value' class="form-control" placeholder="@{{ change_price.type == 1 ? 'понизить' : 'повысить' }} на %" />
              </div>
              {{-- <div class="col-sm-4">
                  <select class='selectpicker' ng-model='change_price.unit'>
                      <option value='1' selected>%</option>
                      <option value='2' selected>руб.</option>
                  </select>
              </div> --}}
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-disabled="changing_price || !change_price.value" type="button" class="btn btn-primary" ng-click="changePrice()">@{{ change_price.type == 1 ? 'понизить' : 'повысить' }}</button>
      </div>
    </div>
  </div>
</div>
