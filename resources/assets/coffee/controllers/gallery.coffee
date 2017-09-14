angular
    .module 'Egecms'
    .controller 'GalleryIndex', ($scope, $attrs, IndexService, Gallery) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Gallery, $scope.current_page, $attrs)
    .controller 'GalleryForm', ($scope, $attrs, $timeout, FormService, Gallery, PhotoService, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Gallery, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Gallery', $scope.id)

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
