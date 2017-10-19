angular
    .module 'Egecms'
    .controller 'TagsIndex', ($scope, $attrs, $timeout, IndexService, Tag) ->
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
                        Tag.update({id: model.id, position: index})

        angular.element(document).ready ->
            IndexService.init(Tag, $scope.current_page, $attrs)
    .controller 'TagsForm', ($scope, $attrs, $timeout, FormService, Tag) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            FormService.init(Tag, $scope.id, $scope.model)
