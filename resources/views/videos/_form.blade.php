<div class="row mb">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'название видео', 'model' => 'title'])
    </div>
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'код', 'model' => 'code'])
    </div>
</div>
<div class="row mb">
    <div class="col-sm-12">
        @include('modules.input', [
            'title' => 'описание',
            'model' => 'description',
            'textarea' => true,
            'attributes' => [
                'maxlength' => 500
            ]
        ])
    </div>
</div>
