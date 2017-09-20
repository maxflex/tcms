<div class="row mb">
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'название работы', 'model' => 'name', 'attributes' => [
            'maxlength' => 35
        ]])
    </div>
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'срок выполнения, дней', 'model' => 'days_to_complete'])
    </div>
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'общая стоимость, руб.', 'model' => 'price'])
    </div>
    <div class="col-sm-3">
        @include('modules.input', [
            'title' => 'дата',
            'class' => 'bs-date-top',
            'model' => 'date'
        ])
    </div>
</div>
<div class="row mb" ng-show='FormService.model.id'>
    <div class="col-sm-6">
        <label class="no-margin-bottom label-opacity">мастер</label>
        <ng-select-new model='FormService.model.master_id' object="masters" label="name" convert-to-number none-text='выберите мастера'></ng-select-new>
    </div>
    <div class="col-sm-6">
         <label class="no-margin-bottom label-opacity">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
</div>
<div class="row mb">
    <div class="col-sm-3">
        <div class="btn-group btn-group-justified" style='margin-bottom: 15px'>
          <a class="btn btn-primary" ng-class="{'active-group-btn': FormService.model.count == 1}" ng-click='FormService.model.count = 1'>1 фото</a>
          <a class="btn btn-primary" ng-class="{'active-group-btn': FormService.model.count == 2}" ng-click='FormService.model.count = 2'>2 фото</a>
          <a class="btn btn-primary" ng-class="{'active-group-btn': FormService.model.count == 3}" ng-click='FormService.model.count = 3'>3 фото</a>
        </div>
    </div>
</div>
<div class="flex-items" style='width: 100%'>
    <div style='width: 200px'>
        Watermark
    </div>
    <div>
        <div class="switch">
            <input id="cmn-toggle-1" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-model="FormService.model.watermark" ng-checked="FormService.model.watermark == 1">
            <label for="cmn-toggle-1"></label>
        </div>
    </div>
</div>
<div class="flex-items" style='width: 100%; margin-bottom: 15px'>
    <div style='width: 200px'>
        От и до
    </div>
    <div>
        <div class="switch">
            <input id="cmn-toggle-2" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-model="FormService.model.before_and_after" ng-checked="FormService.model.before_and_after == 1">
            <label for="cmn-toggle-2"></label>
        </div>
    </div>
</div>
@include('modules.photocrop2')
