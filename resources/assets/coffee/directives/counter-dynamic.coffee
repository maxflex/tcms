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
        rx = /[а-яА-Я]/gi
        
        update = -> 
            maxlength = parseInt(if $scope.ngModel then $scope.max else $scope.min)
            counter.html getInputLengthOnlyLetters() + "/<span class='text-primary'>" + maxlength + "</span>"
            input.attr('maxlength', maxlength + (input.val().length - getInputLengthOnlyLetters()))

        # получить сколько символов введено (считаем только буквы)
        getInputLengthOnlyLetters = ->
            m = input.val().match(rx)
            return if m then m.length else 0
        
        $scope.$watch 'ngModel', (newVal, oldVal) -> update()
        input.on 'keyup', -> update()