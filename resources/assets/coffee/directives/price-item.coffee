angular.module 'Egecms'
    .directive 'priceItem', ->
        restrict: 'E'
        templateUrl: 'directives/price-item'
        scope:
            item:   '='
        controller: ($scope) ->
            $scope.controller_scope = scope
            $scope.sortableOptions =
                items: '.price-position-' + $scope.$id
                axis: 'y'
                cursor: "move"
				opacity: 0.9,
				zIndex: 9999
				containment: "parent"
				tolerance: "pointer"
            # $scope.$watch 'item.positions', (newVal, oldVal) ->
            #     console.log(newVal)
