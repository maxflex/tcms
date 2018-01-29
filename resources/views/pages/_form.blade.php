<div class="row mbs">
    <div class="col-sm-6">
        @include('modules.input', ['title' => 'ключевая фраза', 'model' => 'keyphrase'])
    </div>
    <div class="col-sm-6">
        <div class="field-container">
            <div class="input-group">
                <input ng-keyup="checkExistance('url', $event)" type="text" class="field form-control" required
                       placeholder="отображаемый URL" ng-model='FormService.model.url'
                       ng-model-options="{ allowInvalid: true }">
               <label class="floating-label">отображаемый URL</label>
               <span class="input-group-btn">
                   <button class="btn btn-default" type="button" ng-click="togglePublished()" style='padding: 4px'>
                       <img src="img/svg/www.svg" style='width: 24px' ng-class="{'grayed-out': !FormService.model.published}" />
                   </button>
                   <button class="btn btn-default" type="button" ng-disabled="!FormService.model.keyphrase" ng-click="generateUrl($event)">
                       <span class="glyphicon glyphicon-refresh no-margin-right"></span>
                   </button>
               </span>
            </div>
        </div>
    </div>
</div>

<div class="row mbs">
    <div class="col-sm-12">
        @include('modules.input', [
            'title' => 'title',
            'model' => 'title'
        ])
    </div>
</div>

<div class="row mbs">
    <div class="col-sm-6">
         <label class="no-margin-bottom label-opacity">тэги</label>
        <tags-input ng-model="FormService.model.tags" display-property="text" replace-spaces-with-dashes='false' add-from-autocomplete-only="true" placeholder="добавьте тэг">
           <auto-complete source="loadTags($query)"></auto-complete>
       </tags-input>
    </div>
    <div class="col-sm-6">
        <label class="no-margin-bottom label-opacity">папка</label>
        <select class='form-control selectpicker' ng-model='FormService.model.folder_id' convert-to-number>
            <option value=''>не выбрано</option>
            <option disabled>──────────────</option>
            <option ng-repeat="folder in FolderService.folders track by $index" value="@{{ folder.id }}">
                @{{ folder.name }}
            </option>
        </select>
    </div>
</div>

<div class="row mbl">
    <div class="col-sm-6">
        @include('modules.input', [
            'title' => 'h1 вверху',
            'model' => 'h1'
        ])
        <div style='margin-top: 26px'>
            @include('modules.input', ['title' => 'meta keywords', 'model' => 'keywords'])
        </div>
    </div>
    <div class="col-sm-6">
        @include('modules.input', [
            'title' => 'meta description',
            'model' => 'desc',
            'textarea' => true
        ])
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        <input type="file" name="pageitem" id="fileupload" style='display: none'/ data-url="uploadPageitem">
        <div ui-sortable='sortableOptions' ng-model="FormService.model.items" class="page-items-wrapper">
            <div class="page-item page-item-draggable" ng-repeat="item in FormService.model.items">
                <div class="photo-dashed" ng-click="uploadSvg(item)">
                    <img src="@{{ item.file ? '/storage/pageitems/' + item.file : '/img/icons/nocropped.png' }}" />
                </div>
                <div style='position: relative'>
                    <span class="link-like small" style='position: absolute; right: 0' ng-click="removeService(item)">удалить</span>
                    <div>
                        <div>
                            @include('modules.input', ['title' => 'заголовок', 'attributes' => ['ng-model' => 'item.title', 'maxlength' => 45]])
                        </div>
                    </div>
                    <div>
                        @include('modules.input', [
                            'title' => 'описание',
                            'textarea' => true,
                            'attributes' => [
                                'ng-model' => 'item.description',
                                'maxlength' => 110
                            ]
                        ])
                    </div>
                    <div>
                        @include('modules.input', ['title' => 'номер раздела', 'class' => 'digits-only', 'attributes' => ['ng-model' => 'item.href_page_id']])
                    </div>
                </div>
            </div>
            <div class="page-item page-item-add" ng-show="FormService.model.items.length < 6" ng-click="addService()">
                добавить
            </div>
        </div>
    </div>
</div>

<div class="row mbb">
    <div class="col-sm-12">
        <label>сео текст</label>
        <span class="hint-badge">разрешенные теги: {{ htmlspecialchars('<p>, <br>, <ul>, <li>') }} </span>
        <div id='editor--seo_text' style="height: 300px">@{{ FormService.model.seo_text }}</div>
    </div>
</div>

<div class="row mbb editors">
    <div class="col-sm-12">
        <label ng-class="{'active link-like': !AceService.isShown('editor')}" ng-click="AceService.show('editor')">стационар</label>
        <label ng-class="{'active link-like': !AceService.isShown('editor-mobile')}" ng-click="AceService.show('editor-mobile')">мобильная</label>
        <div id='editor--html' ng-show="AceService.isShown('editor')" style="height: 500px">@{{ FormService.model.html }}</div>
        <div id='editor--html_mobile' ng-show="AceService.isShown('editor-mobile')" style="height: 500px">@{{ FormService.model.html_mobile }}</div>
    </div>
</div>
@include('pages._modals')

<style>
    .input-counter {
        float: none !important;
    }
</style>
