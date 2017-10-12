<div class="row mb">
    <div class="col-sm-12" style='display: flex'>
        <div style='width: 220px'>
            @include('modules.photocrop', ['size' => '{w:1000,h:1000}', 'type' => 'square', 'max' => 1])
        </div>
        <div style='flex: 1'>
            <div class="mbl">
                @include('modules.input', ['title' => 'название', 'model' => 'name', 'attributes' => ['maxlength' => 35]])
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
