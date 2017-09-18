<div class="row mb">
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'название позиции', 'model' => 'name'])
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'цена, руб.', 'model' => 'price'])
    </div>
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'единица измерения', 'model' => 'unit'])
    </div>
</div>
