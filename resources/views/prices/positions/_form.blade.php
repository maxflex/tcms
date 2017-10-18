<div class="row mb">
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'название позиции', 'model' => 'name', 'attributes' => ['maxlength' => 60]])
    </div>
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'цена, руб.', 'model' => 'price'])
    </div>
    <div class="col-sm-3">
        <label class="no-margin-bottom label-opacity">единица измерения</label>
        <ng-select-new model='FormService.model.unit' object="Units" label="title" convert-to-number none-text='не установлено'></ng-select-new>
    </div>
    <div class="col-sm-3">
        <label class="no-margin-bottom label-opacity">родитель</label>
        <ng-select-new model='FormService.model.price_section_id' object="price_sections" label="name" convert-to-number none-text='нет родителя'></ng-select-new>
    </div>
</div>
<div class="row mb">
    <div class="col-sm-3">
         <label class="no-margin-bottom label-opacity">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
</div>
