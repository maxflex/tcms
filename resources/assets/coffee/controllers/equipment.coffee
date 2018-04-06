angular
    .module 'Egecms'
    .controller 'EquipmentIndex', ($scope, $attrs, $timeout, IndexService, Equipment, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Equipment, $scope.current_page, $attrs, {folder: $scope.folder})
            FolderService.init($scope.template.class, $scope.folder, IndexService, Equipment)
    .controller 'EquipmentForm', ($scope, $attrs, $timeout, FormService, Equipment, PhotoService, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FolderService.init($scope.template.class)
            FormService.init(Equipment, $scope.id, $scope.model)
            FormService.model.folder_id = $.cookie('equipment_folder_id') if not FormService.model.id && $.cookie('equipment_folder_id')
            PhotoService.init(FormService, 'Equipment', $scope.id)
            $scope.align_preview = 'right'
            $('#color-picker').colorpicker
                hexNumberSignPrefix: false

        $scope.getContrast = ->
            c = hexToDec(FormService.model.color)
            if (c.r * 0.299 + c.g * 0.587 + c.b * 0.114) > 186
                'white'
            else
                'black'

        hexToDec = (hex) ->
            result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex)
            if result
                r: parseInt(result[1], 16)
                g: parseInt(result[2], 16)
                b: parseInt(result[3], 16)
            else
                null
