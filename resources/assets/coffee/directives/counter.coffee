angular.module('Egecms').directive 'ngCounter', ($timeout) ->
    restrict: 'A'
    link: ($scope, $element, $attrs) ->
        $($element).append "<span class='input-counter'></span>"
        counter = $($element).find('.input-counter')
        input = $($element).parent().find('textarea, input')
        maxlength = input.attr('maxlength')

        input.on 'keyup', -> counter.html $(@).val().length + "/<span class='text-primary'>" + maxlength + "</span>"

        $timeout ->
            input.keyup()
        , 500
