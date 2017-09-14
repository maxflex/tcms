angular
    .module 'Egecms'
    .controller 'ReviewsIndex', ($scope, $attrs, IndexService, Review) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Review, $scope.current_page, $attrs)
    .controller 'ReviewsForm', ($scope, $attrs, $timeout, FormService, Review, Published, Scores, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(Review, $scope.id, $scope.model)

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
