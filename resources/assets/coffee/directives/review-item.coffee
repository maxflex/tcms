angular.module 'Egecms'
    .directive 'reviewItem', ->
        restrict: 'E'
        replace: true
        templateUrl: 'directives/review-item'
        scope:
            model: '='
            level: '='
        controller: ($scope) ->
            $scope.controller_scope = angular.element('[ng-app=Egecms]').scope()
