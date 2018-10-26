angular
    .module 'Egecms'
    .controller 'VideosIndex', ($scope, $attrs, $timeout, IndexService, Video) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            IndexService.init(Video, $scope.current_page, $attrs)

        $scope.sortableOptions =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) =>
                $timeout =>
                    IndexService.page.data.forEach (model, index) =>
                        Video.update({id: model.id, position: index})
    .controller 'VideosForm', ($scope, $attrs, $timeout, FormService, Video, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Video, $scope.id, $scope.model)

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
