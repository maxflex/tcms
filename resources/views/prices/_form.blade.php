<div class="row mb">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'название раздела', 'model' => 'name'])
    </div>
    <div class="col-sm-6">
        <label class="no-margin-bottom label-opacity">родитель</label>
        <ng-select-new model='FormService.model.price_section_id' object="price_sections" label="name" convert-to-number none-text='нет родителя'></ng-select-new>
    </div>
</div>
