angular.module('Egecms')
    .controller 'PaymentRemainders', ($scope, $http, $timeout) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            $timeout ->
                $scope.source_id = 4
                $scope.current_page = 1
                load(1)

        $scope.pageChanged = ->
            load($scope.current_page)
            paginate 'payments/remainders', $scope.current_page

        load = (page) ->
            ajaxStart()
            $http.post 'api/payments/remainders',
                page: page
                source_id: $scope.source_id
            .then (response) ->
                ajaxEnd()
                $scope.data = response.data
