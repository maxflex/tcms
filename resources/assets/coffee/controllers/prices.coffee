angular
    .module 'Egecms'
    .controller 'PricesIndex', ($scope, $attrs, $timeout, $http, PriceSection, PricePosition) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            $http.get('api/prices').then (response) ->
                $scope.items = response.data
            $scope.collapsed_price_sections = if $.cookie("collapsed_price_sections") then JSON.parse($.cookie("collapsed_price_sections")) else []
            $timeout ->
                new Clipboard('.copiable')
            , 1000

        clearChangePrice = (section_id) ->
            $scope.change_price =
                type: '1'
                unit: '1'
                section_id: section_id
                value: null
            $timeout -> $('.selectpicker').selectpicker('refresh')

        getRowsAffected = (item) ->
            return 1 if not item.is_section
            result = 0
            item.items.forEach (item) ->
                result += getRowsAffected(item)
            result


        $scope.changePriceDialog = (item) ->
            clearChangePrice(item.model.id)
            $scope.rows_affected = getRowsAffected(item)
            $('#change-price-modal').modal('show')

        $scope.changePriceRootDialog = ->
            item =
                is_section: true
                items: $scope.items
                model: {id: -1}
            $scope.changePriceDialog(item)

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
    .controller 'PricePositionForm', ($scope, $attrs, $timeout, $http, FormService, PricePosition, Units, Tag) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            FormService.init(PricePosition, $scope.id, $scope.model)
            FormService.redirect_url = 'prices'
        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
