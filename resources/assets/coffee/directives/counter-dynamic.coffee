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
        update = -> counter.html input.val().length + "/<span class='text-primary'>" + (if $scope.ngModel then $scope.max else $scope.min) + "</span>"
        $scope.$watch 'ngModel', (newVal, oldVal) -> update()
        input.on 'keyup', -> update()
        # $($element).append "<span class='input-counter'></span>"
        # counter = $($element).find('.input-counter')
        # input = $($element).parent().find('textarea, input')
        # maxlength = input.attr('maxlength')
        #
        # input.on 'keyup', -> counter.html $(@).val().length + "/<span class='text-primary'>" + maxlength + "</span>"
        #
        # $timeout ->
        #     input.keyup()
        # , 500
