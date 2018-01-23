<div class="row mb">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'название видео', 'model' => 'title', 'attributes' => ['maxlength' => 35]])
    </div>
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'код', 'model' => 'code'])
    </div>
</div>