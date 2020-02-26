angular
    .module 'Egecms'
    .controller 'VideosIndex', ($scope, $attrs, $timeout, IndexService, Video, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Video, $scope.current_page, $attrs, {folder: $scope.folder})
            FolderService.init($scope.template.class, $scope.folder, IndexService, Video)

    .controller 'VideosForm', ($scope, $attrs, $timeout, FormService, Video, Tag, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FolderService.init($scope.template.class)
            FormService.init(Video, $scope.id, $scope.model)
            FormService.model.folder_id = $.cookie('video_folder_id') if not FormService.model.id && $.cookie('video_folder_id')

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
