angular
    .module 'Egecms'
    .controller 'PricesIndex', ($scope, $attrs, $timeout, $http, $rootScope, PriceSection, PricePosition, Units) ->
        bindArguments($scope, arguments)
        $scope.Units = Units
        $scope.findById = $rootScope.findById
        angular.element(document).ready ->
            params = if $scope.id then "?id=#{$scope.id}" else ""
            $http.get("api/prices#{params}").then (response) ->
                $scope.sections = response.data
            $http.get("api/prices/positions#{params}").then (response) ->
                $scope.positions = response.data
            $timeout ->
                new Clipboard('.copiable')
            , 1000

        clearChangePrice = ->
            $scope.change_price =
                type: '1'
                unit: '1'
                section_id: $scope.id
                value: null
            $timeout -> $('.selectpicker').selectpicker('refresh')

        # getRowsAffected = (item) ->
        #     return 1 if not item.hasOwnProperty('sections_count')
        #     result = 0
        #     item.sections.forEach (item) ->
        #         result += getRowsAffected(item)
        #     result

        $scope.hide = (item) ->
            item.is_hidden = !item.is_hidden
            Resource = if item.hasOwnProperty('sections_count') then PriceSection else PricePosition
            Resource.update({id: item.id, is_hidden: item.is_hidden})

        $scope.changePriceDialog = (item) ->
            clearChangePrice()
            # $scope.rows_affected = getRowsAffected()
            $('#change-price-modal').modal('show')

        $scope.changePriceRootDialog = ->
            $scope.changePriceDialog()

        $scope.changePrice = ->
            ajaxStart()
            $scope.changing_price = true
            $http.post 'api/prices/change', $scope.change_price
            .then ->
                location.reload()

        $scope.toggleCollapse = (item) ->
            id = item.model.id
            if id in $scope.collapsed_price_sections
                $scope.collapsed_price_sections = _.without($scope.collapsed_price_sections, id)
            else
                $scope.collapsed_price_sections.push(id)
            $.cookie("collapsed_price_sections", JSON.stringify($scope.collapsed_price_sections), { expires: 365, path: '/' })

        $scope.isCollapsed = (item) -> item.model.id in $scope.collapsed_price_sections

        $scope.sortableOptionsSections =
            update: (event, ui) ->
                $timeout ->
                    $scope.sections.forEach (item, index) ->
                        PriceSection.update({id: item.id, position: index})
            items: '.price-section'
            axis: 'y'
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
        
         $scope.sortableOptionsPositions =
            update: (event, ui) ->
                $timeout ->
                    $scope.positions.forEach (item, index) ->
                        PricePosition.update({id: item.id, position: index})
            items: '.price-position'
            axis: 'y'
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999


    .controller 'PricesForm', ($scope, $attrs, $timeout, $http, FormService, PriceSection) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PriceSection, $scope.id, $scope.model)
            FormService.redirect_url = 'prices?id=' + $scope.model.price_section_id
    .controller 'PricePositionForm', ($scope, $attrs, $timeout, $http, FormService, PricePosition, Units, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PricePosition, $scope.id, $scope.model)
            FormService.redirect_url = 'prices?id=' + $scope.model.price_section_id
        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
