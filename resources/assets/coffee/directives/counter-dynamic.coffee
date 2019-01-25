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
        $scope.text = input.val()

        # not counted
        rx = /[a-zA-Z1-9\[\]\|]/gi

        update = ->
            maxlength = parseInt(if $scope.ngModel then $scope.max else $scope.min)
            counter.html getInputLengthOnlyAllowed() + "/<span class='text-primary'>" + maxlength + "</span>"
            input.attr('maxlength', maxlength + ($scope.text.length - getInputLengthOnlyAllowed()))

        getInputLengthOnlyAllowed = ->
            # debugger
            m = $scope.text.match(rx) 
            return if m then ($scope.text.length - m.length) else $scope.text.length

        $scope.$watch 'ngModel', (newVal, oldVal) -> update()

        $timeout -> input.trigger('input')

        input.on 'input', (e) -> 
            # console.log($(e.target).val())
            $scope.text = $(e.target).val()
            update()

        input.on 'paste', (e) ->
            # console.log('%cpaste', 'color:LightCoral')
            # console.log(e.originalEvent.clipboardData.getData('text'))
            $scope.text = e.originalEvent.clipboardData.getData('text')
            update()
