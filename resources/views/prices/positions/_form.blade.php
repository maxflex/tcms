<div class="row mb">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'название позиции', 'model' => 'name', 'attributes' => ['maxlength' => 60]])
    </div>
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'цена, руб.', 'model' => 'price'])
    </div>
</div>
<div class="row mb">
    <div class="col-sm-6">
        <label class="no-margin-bottom label-opacity">единица измерения</label>
        <ng-select-new model='FormService.model.unit' object="Units" label="title" convert-to-number none-text='не установлено'></ng-select-new>
    </div>
    <div class="col-sm-6">
        <label class="no-margin-bottom label-opacity">родитель</label>
        <ng-select-new model='FormService.model.price_section_id' object="price_sections" label="name" convert-to-number none-text='нет родителя'></ng-select-new>
    </div>
</div>
<div class="row mb">
    <div class="col-sm-12">
        <label class="no-margin-bottom label-opacity flex-items-center" style='padding-bottom: 2px'>
            <span style='margin-right: 5px; top: -1px; position: relative'>тэги</span>
            <span aria-label="Доступно после сохранения записи" data-microtip-position="bottom" role="tooltip">
                <i class='fa fa-info-circle'></i>
            </span>
        </label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
</div>
