angular
    .module 'Egecms'
    .controller 'EquipmentIndex', ($scope, $attrs, $timeout, IndexService, Equipment, FolderService) ->
        bindArguments($scope, arguments)
        $scope.sortableOptions =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) ->
                $timeout ->
                    IndexService.page.data.forEach (model, index) ->
                        Equipment.update({id: model.id, position: index})

        angular.element(document).ready ->
            IndexService.init(Equipment, $scope.current_page, $attrs, {folder: $scope.folder})
            FolderService.init($scope.template.class, $scope.folder)
    .controller 'EquipmentForm', ($scope, $attrs, $timeout, FormService, Equipment, PhotoService, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Equipment, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Equipment', $scope.id)
            FolderService.init($scope.template.class)
