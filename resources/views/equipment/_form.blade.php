<div class="row mb">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'название оборудования', 'model' => 'name'])
    </div>
</div>
<div class="row mb">
      <div class="col-sm-12">
        @include('modules.input', [
            'title' => 'описание',
            'model' => 'description',
            'textarea' => true,
            'attributes' => [
                'ng-counter' => true,
            ]
        ])
    </div>
</div>

@include('modules.photocrop', ['size' => '{w:1000,h:1000}', 'type' => 'square', 'max' => 1])
