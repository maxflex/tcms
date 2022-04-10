angular.module 'Egecms'
    .directive 'priceItemTag', ->
        restrict: 'E'
        replace: true
        templateUrl: 'directives/price-item-tag'
        scope:
            model: '='
            level: '='
        controller: ($scope, $rootScope, Units) ->
            $scope.Units = Units
            $scope.controller_scope = angular.element('[ng-app=Egecms]').scope()
            $scope.findById = $rootScope.findById
