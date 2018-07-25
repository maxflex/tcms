<div class="row mb">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'название видео', 'model' => 'title', 'attributes' => ['maxlength' => 35]])
    </div>
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'код', 'model' => 'code'])
    </div>
</div>
<div class="row mb">
    <div class="col-sm-12">
         <label class="no-margin-bottom label-opacity">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
</div>
