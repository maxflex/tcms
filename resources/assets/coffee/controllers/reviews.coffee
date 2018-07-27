angular
    .module 'Egecms'
    .controller 'ReviewsIndex', ($scope, $attrs, IndexService, Review, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Review, $scope.current_page, $attrs, {folder: $scope.folder})
            FolderService.init($scope.template.class, $scope.folder, IndexService, Review)

    .controller 'ReviewsForm', ($scope, $attrs, $timeout, FormService, Review, Published, Scores, Tag, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FolderService.init($scope.template.class)
            FormService.init(Review, $scope.id, $scope.model)
            FormService.model.folder_id = $.cookie('review_folder_id') if not FormService.model.id && $.cookie('review_folder_id')

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
