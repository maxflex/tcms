<div class="row mb">
    <div class="col-sm-9">
        @include('modules.input', ['title' => 'компонент ' . $number, 'model' => 'component_' . $number, 'attributes' => ['maxlength' => 30]])
    </div>
    <div class="col-sm-3">
        @include('modules.input', ['title' => 'стоимость, руб.', 'model' => 'price_' . $number])
    </div>
</div>
