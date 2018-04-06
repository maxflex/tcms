<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/css/bootstrap-colorpicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.2/js/bootstrap-colorpicker.min.js"></script>

<div class="row mb">
    <div class="col-sm-12" style='display: flex'>
        <div style='width: 220px'>
            @include('modules.photocrop', ['size' => '100', 'type' => 'rectangle', 'max' => 1])
        </div>
        <div style='flex: 1'>
            <div class="row mbl">
                <div class="col-sm-6">
                    @include('modules.input', ['title' => 'название', 'model' => 'name', 'attributes' => ['maxlength' => 35]])
                </div>
                <div class="col-sm-6">
                    @include('modules.folder-select')
                </div>
            </div>
            <div class="mbl">
               @include('modules.input', [
                   'title' => 'описание',
                   'model' => 'description',
                   'textarea' => true,
                   'attributes' => [
                       'maxlength' => 500,
                   ]
               ])
           </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 flex-items" style="align-items: center">
        <div style='margin-right: 15px'>
            Кнопка
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-5" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-click='FormService.model.button = !FormService.model.button' ng-checked='FormService.model.button'>
                <label for="cmn-toggle-5" style='margin: 0'></label>
            </div>
        </div>
        <div style='margin-left: 60px; margin-right: 15px'>
          Цвет
        </div>
        <div style='width: 110px'>
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon1">#</span>
            <input type="text" class="form-control" id='color-picker' placeholder="000000" aria-describedby="basic-addon1" maxlength="6" ng-model="FormService.model.color">
          </div>
        </div>
        <div class="btn-group" role="group" style='margin-left: 60px'>
            <button type="button" class="btn btn-default" ng-click="align_preview = 'left'">
                <span class="glyphicon glyphicon-align-left"></span>
              </button>
            <button type="button" class="btn btn-default" ng-click="align_preview = 'right'">
                <span class="glyphicon glyphicon-align-right"></span>
              </button>
        </div>
        <div style='margin-left: 5px; font-size: 12px; color: rgba(0, 0, 0, 0.3)'>
            (функция положения только для превью)
        </div>
    </div>
</div>

<div ng-show="FormService.model.photos[0].cropped_url && FormService.model.color && FormService.model.color.length >= 6">
  <div class="common-eq">
    <div class="equipment-item-full @{{ align_preview }} @{{ getContrast() }}">
      <div class="equipment-additional-block" ng-style="{background: '#' + FormService.model.color}"></div>
      <div class="equipment-overlay" ng-style="{background: 'linear-gradient(to ' + (align_preview == 'left' ? 'right' : 'left') + ', #' + FormService.model.color + ' 33%, transparent 95%)'}"></div>
      <div class="equipment-image">
        <img ng-src="@{{ FormService.model.photos[0].cropped_url }}" class="equipment-photo">
      </div>
      <div class="equipment-text-block">
        <div>
          <b class="ng-binding">@{{ FormService.model.name }}</b>
          <span class="ng-binding">@{{ FormService.model.description }}</span>
          <div>
            <button ng-show="FormService.model.button" class="btn-border ng-hide" href="#">продробнее...</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
