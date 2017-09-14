angular
    .module 'Egecms'
    .controller 'MastersIndex', ($scope, $attrs, IndexService, Master) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Master, $scope.current_page, $attrs)
    .controller 'MastersForm', ($scope, $attrs, $timeout, $http, FormService, Master, Photo, PhotoService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Master, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Master', $scope.id)
