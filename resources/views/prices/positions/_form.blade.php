<div class="row mb">
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'название позиции', 'model' => 'name'])
    </div>
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'цена, руб.', 'model' => 'price'])
    </div>
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'единица измерения', 'model' => 'unit'])
    </div>
    <div class="col-sm-3">
        <label class="no-margin-bottom label-opacity">родитель</label>
        <ng-select-new model='FormService.model.price_section_id' object="price_sections" label="name" convert-to-number none-text='нет родителя'></ng-select-new>
    </div>
</div>
