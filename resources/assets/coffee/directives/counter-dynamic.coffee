angular.module('Egecms').directive 'ngCounterDynamic', ($timeout) ->
    restrict: 'A'
    require: 'ngModel'
    scope:
        ngModel: '='
        min: '@'
        max: '@'
    link: ($scope, $element, $attrs) ->
        $($element).append "<span class='input-counter'></span>"
        counter = $($element).find('.input-counter')
        input = $($element).parent().find('textarea, input')

        # not counted
        rx = /[a-zA-Z1-9\[\]\|]/gi

        update = ->
            maxlength = parseInt(if $scope.ngModel then $scope.max else $scope.min)
            counter.html getInputLengthOnlyAllowed() + "/<span class='text-primary'>" + maxlength + "</span>"
            input.attr('maxlength', maxlength + (input.val().length - getInputLengthOnlyAllowed()))

        getInputLengthOnlyAllowed = ->
            val = input.val()
            m = val.match(rx)
            return if m then (val.length - m.length) else 0

        $scope.$watch 'ngModel', (newVal, oldVal) -> update()
        input.on 'keyup', -> update()
