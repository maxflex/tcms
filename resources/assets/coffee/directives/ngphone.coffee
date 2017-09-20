angular.module('Egecms').directive 'ngPhone', ($timeout) ->
    restrict: 'A'
    controller: ($scope, $element, $attrs, $timeout) ->
        $timeout ->
            $element.mask("+7 (999) 999-99-99", { autoclear: false })
        , 300
