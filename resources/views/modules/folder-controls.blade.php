<span ng-show="!FolderService.folders.length && !IndexService.page.data.length" ng-click="FolderService.delete()">удалить папку</span>
<span ng-show="FolderService.current_folder_id" ng-click="FolderService.editModal()">редактировать</span>
<span ng-click="FolderService.createModal()">создать папку</span>

<style>
    .panel-heading-main .col-sm-4.right {
        width: 50%;
        float: right;
    }
</style>