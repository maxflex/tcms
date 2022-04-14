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
                'maxlength' => 150
            ]
        ])

        <div style='margin-top: 14px'>
            <label class="no-margin-bottom label-opacity">тэги</label>
            <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
               <auto-complete source="loadTags($query)"></auto-complete>
           </tags-input>
        </div>
    </div>
</div>

<div class='row' ng-show='FormService.model.reviews.length > 0'>
    <div class='col-sm-12'>
        <h4 class='mb'>Отзывы:</h4>
        <table class='table'>
            <tr ng-repeat='model in FormService.model.reviews'>
                <td width='20'>
                    <input type='checkbox' ng-model='selectedIds.reviews[model.id]'>
                </td>
                @include('reviews/_item')
            </tr>
        </table>
        <button class='btn btn-primary'
            ng-disabled="getSelectedIds('reviews').length === 0"
            ng-click="openMassEditDialog('reviews')">
            массовое редактирование
        </button>
    </div>
</div>


<div class='row' style='margin-top: 50px' ng-show='FormService.model.videos.length > 0'>
    <div class='col-sm-12'>
        <h4 class='mb'>Видео:</h4>
        <table class='table'>
            <tr ng-repeat='model in FormService.model.videos'>
                <td width='20'>
                    <input type='checkbox' ng-model='selectedIds.videos[model.id]'>
                </td>
                @include('videos/_item')
            </tr>
        </table>
        <button class='btn btn-primary'
            ng-disabled="getSelectedIds('videos').length === 0"
            ng-click="openMassEditDialog('videos')">
            массовое редактирование
        </button>
    </div>
</div>

<div class='row' style='margin-top: 50px' ng-show='FormService.model.gallery.length > 0'>
    <div class='col-sm-12'>
        <h4 class='mb'>Галерея:</h4>
        <table class='table'>
            <tr ng-repeat='model in FormService.model.gallery'>
                <td width='20'>
                    <input type='checkbox' ng-model='selectedIds.gallery[model.id]'>
                </td>
                @include('galleries/_item')
            </tr>
        </table>
        <button class='btn btn-primary'
            ng-disabled="getSelectedIds('gallery').length === 0"
            ng-click="openMassEditDialog('gallery')">
            массовое редактирование
        </button>
    </div>
</div>

@include('masters.modals')
