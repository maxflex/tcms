angular.module 'Egecms'
    .directive 'mobileMenuItem', ->
        restrict: 'E'
        replace: true
        templateUrl: 'directives/mobile-menu-item'
        scope:
            item:   '='
        controller: ($scope, $timeout, $rootScope, MobileMenu) ->
            $scope.findById = $rootScope.findById
            $scope.controller_scope = scope
            
            $scope.sortableOptions =
                update: (event, ui) ->
                    $timeout ->
                        $scope.item.children.forEach (item, index) ->
                            MobileMenu.update({id: item.id, position: index})
                items: '.menu-item-' + $scope.$id
                axis: 'y'
                cursor: "move"
                opacity: 0.9,
                zIndex: 9999