angular
    .module 'Egecms'
    .controller 'PricesIndex', ($scope, $attrs, $timeout, $http, PriceSection, PricePosition) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            $http.get('api/prices').then (response) ->
                $scope.items = response.data

        clearChangePrice = (section_id) ->
            $scope.change_price =
                type: '1'
                unit: '1'
                section_id: section_id
                value: null
            $timeout -> $('.selectpicker').selectpicker('refresh')

        $scope.changePriceDialog = (section_id) ->
            clearChangePrice(section_id)
            $('#change-price-modal').modal('show')

        $scope.changePrice = ->
            ajaxStart()
            $scope.changing_price = true
            $http.post 'api/prices/change', $scope.change_price
            .then ->
                location.reload()

        $scope.sortableOptions =
            update: (event, ui) ->
                $timeout ->
                    $scope.items.forEach (item, index) ->
                        Resource = if item.is_section then PriceSection else PricePosition
                        Resource.update({id: item.model.id, position: index})
            items: '.price-item-' + $scope.$id
            axis: 'y'
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999


    .controller 'PricesForm', ($scope, $attrs, $timeout, $http, FormService, PriceSection) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PriceSection, $scope.id, $scope.model)
            FormService.redirect_url = 'prices'
    .controller 'PricePositionForm', ($scope, $attrs, $timeout, $http, FormService, PricePosition, Units) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PricePosition, $scope.id, $scope.model)
            FormService.redirect_url = 'prices'
