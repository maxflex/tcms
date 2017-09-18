angular.module 'Egecms'
    .directive 'priceItem', ->
        restrict: 'E'
        templateUrl: 'directives/price-item'
        scope:
            item:   '='
        controller: ($scope) ->
            $scope.controller_scope = scope
