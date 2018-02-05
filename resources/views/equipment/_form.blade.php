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
    <div class="col-sm-12 flex-items">
        <div style='width: 75px; position: relative; top: 2px'>
            Кнопка
        </div>
        <div>
            <div class="switch">
                <input id="cmn-toggle-5" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-click='FormService.model.button = !FormService.model.button' ng-checked='FormService.model.button'>
                <label for="cmn-toggle-5"></label>
            </div>
        </div>
    </div>
</div>