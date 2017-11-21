{{-- ДОБАВЛЕНИЕ ПЛАТЕЖА --}}
<div id="payment-stream-modal" class="modal" role="dialog" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
          <div class="form-group simpleinput-wrapper">
              <label>дата</label>
              <input type="text" class="bs-date-top datemask" ng-model="modal_payment.date" id="payment-date">
              <i class="fa fa-caret-down" aria-hidden="true"></i>
          </div>
          <div class="form-group simpleinput-wrapper">
              <label>сумма</label>
              <input type="text" ng-model="modal_payment.sum_comma" class="digits-only-floatcomma">
          </div>
          <div class="form-group simpleinput-wrapper">
              <label>источник</label>
              <input readonly="true" type="text" value="@{{ modal_payment.source_id ? findById(sources, modal_payment.source_id).name : 'не указано' }}">
              <i class="fa fa-caret-down" aria-hidden="true"></i>
              <select ng-model="modal_payment.source_id" class="hidden-select">
                  <option value="">не указано</option>
                  <option disabled>──────────────</option>
                <option ng-repeat="source in sources" ng-value="source.id">@{{ source.name }}</option>
              </select>
          </div>
          <div class="form-group simpleinput-wrapper">
              <label>адресат</label>
              <input readonly="true" type="text" value="@{{ modal_payment.addressee_id ? findById(sources, modal_payment.addressee_id).name : 'не указано' }}">
              <i class="fa fa-caret-down" aria-hidden="true"></i>
              <select ng-model="modal_payment.addressee_id" class="hidden-select">
                  <option value="">не указано</option>
                  <option disabled>──────────────</option>
                <option ng-repeat="source in sources" ng-value="source.id">@{{ source.name }}</option>
              </select>
          </div>
          <div class="form-group simpleinput-wrapper">
              <label>статья</label>
              <input readonly="true" type="text" value="@{{ modal_payment.expenditure_id ? getExpenditure(modal_payment.expenditure_id).name : 'не указано' }}">
              <i class="fa fa-caret-down" aria-hidden="true"></i>
              <select ng-model="modal_payment.expenditure_id" class="hidden-select" convert-to-number>
                  <option value="">не указано</option>
                  {{-- <option disabled>──────────────</option> --}}
                    <optgroup ng-repeat="expenditure in expenditures" label="@{{ expenditure.name }}" ng-hide="!expenditure.data.length">
                        <option ng-repeat="d in expenditure.data" value="@{{ d.id }}">@{{ d.name }}</option>
                    </optgroup>
              </select>
          </div>
          <div class="form-group simpleinput-wrapper">
              <label>назначение</label>
              <textarea ng-model="modal_payment.purpose" rows="3"></textarea>
          </div>
          <div>
              <i class="fa fa-star table-star" ng-class="{'active': modal_payment.checked}" aria-hidden="true" ng-click="modal_payment.checked = !modal_payment.checked"></i>
          </div>
          <div ng-hide="modal_payment.id">
              <input type="checkbox" name="checkbox" id="checkbox_id" ng-model="modal_payment.create_loan" ng-true-value="1" ng-false-value="0">
              <label for="checkbox_id" style='font-weight: normal'>создать заём</label>
          </div>
      </div>
      <div class="modal-footer center">
        <button ng-hide="modal_payment.id" type="button" class="btn btn-primary" ng-disabled="adding_payment" ng-click="savePayment()">добавить</button>
        <div ng-show="modal_payment.id" style='text-align: left'>
            <span class="text-gray">@{{ UserService.getLogin(modal_payment.user_id) }} @{{ formatDateTime(modal_payment.created_at) }}</span>
            <div class="pull-right">
                <span class="link-like" style='margin-right: 12px' ng-click="savePayment()">сохранить</span>
                <span class="link-like" ng-click="deletePayment()">удалить</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
