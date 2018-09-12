angular
    .module 'Egecms'
    .controller 'HeaderIndex', ($rootScope, $scope, $timeout, $http, LogTypes) ->
        bindArguments($scope, arguments)

        $scope.save = ->
            ajaxStart()
            $http.post '/api/header', {header: $scope.header}
            .then -> ajaxEnd()
