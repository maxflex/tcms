angular.module 'Egecms'
    .directive 'priceSection', ->
        restrict: 'E'
        templateUrl: 'directives/price-section'
        scope:
            item:   '='