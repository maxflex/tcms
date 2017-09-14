angular
    .module 'Egecms'
    .controller 'EquipmentIndex', ($scope, $attrs, IndexService, Equipment) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Equipment, $scope.current_page, $attrs)
    .controller 'EquipmentForm', ($scope, $attrs, $timeout, FormService, Equipment, PhotoService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Equipment, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Equipment', $scope.id)
