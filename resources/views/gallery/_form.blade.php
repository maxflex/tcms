<div class="row mb">
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'название фото', 'model' => 'name'])
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
@include('modules.photocrop', ['size' => '{w:2000,h:1100}', 'type' => 'square', 'max' => 1])
