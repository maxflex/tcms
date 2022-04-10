angular.module 'Egecms'
    .directive 'galleryItem', ->
        restrict: 'E'
        replace: true
        templateUrl: 'directives/gallery-item'
        scope:
            model: '='
            level: '='
        controller: ($scope) ->
            $scope.controller_scope = angular.element('[ng-app=Egecms]').scope()
