@include('modules.photocrop', ['size' => '{w:1000,h:1000}', 'type' => 'circle', 'max' => 5])
<div class="row mb">
    <div class="col-sm-3">
        <div class="mbl">
            @include('modules.input', ['title' => 'фамилия', 'model' => 'last_name'])
        </div>
        <div class="mbl">
            @include('modules.input', ['title' => 'имя', 'model' => 'first_name'])
        </div>
        <div class="mbl">
            @include('modules.input', ['title' => 'отчество', 'model' => 'middle_name'])
        </div>
        <div class="mbl">
            @include('modules.input', ['title' => 'код видео', 'model' => 'video'])
        </div>
    </div>
    <div class="col-sm-9">
        @include('modules.input', [
            'title' => 'описание мастера',
            'model' => 'description',
            'textarea' => true,
            'attributes' => [
                'ng-counter' => true,
                'maxlength' => 1000
            ]
        ])
    </div>
</div>
