angular.module 'Egecms'
    .directive 'priceItem', ->
        restrict: 'E'
        templateUrl: 'directives/price-item'
        scope:
            item:   '='
        controller: ($scope, $timeout, PriceSection, PricePosition) ->
            $scope.controller_scope = scope
            $scope.sortableOptions =
                update: (event, ui) ->
                    $timeout ->
                        $scope.item.items.forEach (item, index) ->
                            Resource = if item.is_section then PriceSection else PricePosition
                            Resource.update({id: item.model.id, position: index})
                items: '.price-item-' + $scope.$id
                axis: 'y'
                cursor: "move"
                opacity: 0.9,
                zIndex: 9999
                # containment: "parent"
                # tolerance: "pointer"
            # $scope.$watch 'item.positions', (newVal, oldVal) ->
            #     console.log(newVal)
