angular
    .module 'Egecms'
    .controller 'VideosIndex', ($scope, $attrs, IndexService, Video) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Video, $scope.current_page, $attrs)
    .controller 'VideosForm', ($scope, $attrs, $timeout, FormService, Video) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Video, $scope.id, $scope.model)
