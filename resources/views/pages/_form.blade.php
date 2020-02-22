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
    <div class="col-sm-6">
        @include('modules.input', [
            'title' => 'title',
            'model' => 'title'
        ])
    </div>
    <div class="col-sm-6">
        @include('modules.input', [
            'title' => 'SEO номера страниц',
            'model' => 'seo_page_ids'
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
        @include('modules.folder-select')
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
<div ng-show="FormService.model.items.length > 0" class='row'>
    <div class='col-sm-12'>
        <input type="checkbox" id="oneline" name="oneline"
            ng-model="FormService.model.no_icons"
            ng-checked="FormService.model.no_icons == 1"
            ng-true-value='1'
            ng-false-value='0'
        >
        <label for="oneline" style='padding-left: 5px; margin-right: 16px'>без иконок</label>

        <input type="checkbox" id="oneline" name="oneline" ng-model="FormService.model.items[0].is_one_line" ng-checked="FormService.model.items[0].is_one_line == 1" ng-true-value='1' ng-false-value='0'>
        <label for="oneline" style='padding-left: 5px'>в одну строку</label>
    </div>
</div>
<div class="row mbs">
    <div class="col-sm-12">
        <input type="file" name="pageitem" id="fileupload" style='display: none' data-url="uploadPageitem">
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
                        <div class="field-container">
                          <textarea rows="4" class="field form-control" required placeholder="описание" ng-model='item.description' ng-model-options="{ allowInvalid: true }"></textarea>
                          <label style='position: absolute; top: -18px' ng-counter-dynamic min='110' max='500' ng-model='item.is_one_line'>описание</label>
                        </div>
                    </div>
                    <div>
                        @include('modules.input', ['title' => 'номер раздела', 'class' => 'digits-only', 'attributes' => ['ng-model' => 'item.href_page_id']])
                    </div>
                </div>
            </div>
            <div class="page-item page-item-add" ng-click="addService()">
                добавить
            </div>
        </div>
    </div>
</div>

<div class="row mbb">
    <div class="col-sm-12">
        <label>сео текст</label>
        <span class="hint-badge">разрешенные теги: {{ htmlspecialchars(implode(', ', App\Models\Tag::ALLOWED_TAGS)) }} </span>
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
