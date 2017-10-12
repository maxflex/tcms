<div class="row mb">
      <div class="col-sm-12">
        @include('modules.input', [
            'title' => 'текст отзыва',
            'model' => 'body',
            'textarea' => true,
            'attributes' => [
                'maxlength' => 500
            ]
        ])
    </div>
</div>
<div class="row mb">
    <div class="col-sm-4">
        @include('modules.input', ['title' => 'подпись', 'model' => 'signature', 'attributes' => [
            'maxlength' => 35
        ]
    ])
    </div>
    <div class="col-sm-4">
        @include('modules.input', [
            'title' => 'дата',
            'class' => 'bs-date-top',
            'model' => 'date'
        ])
    </div>
    <div class="col-sm-4">
        <label class="no-margin-bottom label-opacity">оценка</label>
        <ng-select-new model='FormService.model.score' object="Scores" label="title" convert-to-number none-text='не установлено'></ng-select-new>
    </div>
</div>

<div class="row mb">
    <div class="col-sm-4">
        <label class="no-margin-bottom label-opacity">публикация</label>
        <ng-select-new model='FormService.model.published' object="Published" label="title" convert-to-number></ng-select-new>
    </div>
    <div class="col-sm-4">
        <label class="no-margin-bottom label-opacity">мастер</label>
        <ng-select-new model='FormService.model.master_id' object="masters" label="name" convert-to-number none-text='выберите мастера'></ng-select-new>
    </div>
    <div class="col-sm-4">
         <label class="no-margin-bottom label-opacity">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
</div>
