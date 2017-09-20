angular
    .module 'Egecms'
    .controller 'UsersIndex', ($scope, $attrs, IndexService, User) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(User, $scope.current_page, $attrs)
    .controller 'UsersForm', ($scope, $attrs, $timeout, FormService, User, PhotoService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(User, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Master', $scope.id)

        $scope.toggleRights = (right) ->
            right = parseInt(right)
            if $scope.allowed(right)
                FormService.model.rights = _.reject FormService.model.rights, (val) -> val is right
            else
                FormService.model.rights.push(right)

        $scope.allowed = (right) -> FormService.model.rights.indexOf(parseInt(right)) isnt -1
