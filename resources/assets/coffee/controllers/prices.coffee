angular
    .module 'Egecms'
    .controller 'PricesIndex', ($scope, $attrs, $timeout, $http, IndexService, PriceSection) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            IndexService.init(PriceSection, $scope.current_page, $attrs)

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


    .controller 'PricesForm', ($scope, $attrs, $timeout, $http, FormService, PriceSection) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PriceSection, $scope.id, $scope.model)
            FormService.redirect_url = 'prices'
    .controller 'PricePositionForm', ($scope, $attrs, $timeout, $http, FormService, PricePosition) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PricePosition, $scope.id, $scope.model)
            FormService.redirect_url = 'prices'
