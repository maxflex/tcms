<label class="no-margin-bottom label-opacity">папка</label>
<select class='form-control selectpicker' ng-if="FolderService.tree" ng-model='FormService.model.folder_id' convert-to-number>
    <option value=''>не выбрано</option>
    <option disabled>──────────────</option>
    <option ng-repeat="folder in FolderService.tree track by $index" value="@{{ folder.id }}"
        data-content="@{{ folder.name }}">
    </option>
</select>
