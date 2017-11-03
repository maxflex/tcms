<div class="row mb">
    <div class="col-sm-12">
        @include('modules.input', ['title' => 'название тега', 'model' => 'text', 'attributes' =>[
            'ng-keyup' => "checkExistance('url', \$event)"
        ]])
    </div>
</div>
