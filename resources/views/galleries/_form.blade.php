<div class="row mb" ng-show="FormService.model.id">
    <div class="col-sm-4">
        <div style='margin-bottom: 6px; font-size: 12px; color: rgba(0, 0, 0, 0.3)'>
            разрешение: 4000x2000<br />
            форматы: jpg, jpeg, png<br />
            максимальный размер: 7мб
        </div>
        <div style='margin-bottom: 12px'>
            <a class="pointer" ng-click="editOrUpload(1)" ng-show="FormService.model.photos.length == 0">загрузить</a>
            <a class="pointer" ng-click="PhotoService.selected_photo_index = 0; PhotoService.loadNew()" ng-show="FormService.model.photos.length > 0" style='margin-right: 10px'>загрузить другое</a>
            <a class="pointer" ng-click="PhotoService.selected_photo_index = 0; PhotoService.delete()" ng-show="FormService.model.photos.length > 0">удалить</a>
        </div>
        <div class="flex-items" style='width: 100%'>
            <div style='width: 200px'>
                Watermark
            </div>
            <div>
                <div class="switch">
                    <input id="cmn-toggle-1" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-model="FormService.model.watermark" ng-checked="FormService.model.watermark == 1">
                    <label for="cmn-toggle-1"></label>
                </div>
            </div>
        </div>
        <div class="flex-items" style='width: 100%; margin-bottom: 15px'>
            <div style='width: 200px'>
                До и после
            </div>
            <div>
                <div class="switch">
                    <input id="cmn-toggle-2" class="cmn-toggle cmn-toggle-round-flat" type="checkbox" ng-model="FormService.model.before_and_after" ng-checked="FormService.model.before_and_after == 1">
                    <label for="cmn-toggle-2"></label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        @include('modules.photocrop2')
    </div>
    <div class="col-sm-6">
        <div ng-show='FormService.model.photos.length'>
            <img ng-click="preview()" class="pointer mbb" src='/img/gallery/@{{FormService.model.id}}.jpg?version=@{{ version }}' style='width: 100%' />
            <center>
                @{{ FormService.model.file_size }}, @{{ FormService.model.image_size }}
            </center>
        </div>
        <div ng-show='!FormService.model.photos.length' class="no-photo">
            нет фото
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="mbl">
            @include('modules.input', ['title' => 'название работы', 'model' => 'name', 'attributes' => [
                'maxlength' => 31
            ]])
        </div>
        <div class="mbb">
            @include('modules.input', ['title' => 'срок выполнения, дней', 'model' => 'days_to_complete'])
        </div>
        <div class="mbb">
            @include('modules.folder-select')
        </div>
    </div>
</div>
@include('galleries._component', ['number' => 1])
@include('galleries._component', ['number' => 2])
@include('galleries._component', ['number' => 3])
@include('galleries._component', ['number' => 4])
@include('galleries._component', ['number' => 5])
@include('galleries._component', ['number' => 6])
<div class="row mb">
    <div class="col-sm-9"></div>
    <div class="col-sm-3">
        <div class="blocker-div"></div>
        @include('modules.input', ['title' => 'общая стоимость, руб.', 'attributes' => ['ng-value' => 'getTotalPrice()']])
    </div>
</div>

<div class="row mb" ng-show='FormService.model.id'>
    <div class="col-sm-4">
        <label class="no-margin-bottom label-opacity">мастер</label>
        <ng-select-new model='FormService.model.master_id' object="masters" label="name" convert-to-number none-text='выберите мастера'></ng-select-new>
    </div>
    <div class="col-sm-5">
         <label class="no-margin-bottom label-opacity">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
    <div class="col-sm-3">
        @include('modules.input', [
            'title' => 'дата',
            'class' => 'bs-date-top',
            'model' => 'date'
        ])
    </div>
</div>