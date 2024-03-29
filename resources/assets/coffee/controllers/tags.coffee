angular
    .module 'Egecms'
    .controller 'TagsIndex', ($scope, $attrs, $timeout, IndexService, Tag) ->
        bindArguments($scope, arguments)

        $scope.sortableOptions =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) ->
                $timeout ->
                    IndexService.page.data.forEach (model, index) ->
                        Tag.update({id: model.id, position: index})

        angular.element(document).ready ->
            IndexService.init(Tag, $scope.current_page, $attrs)
    .controller 'TagsForm', ($scope, $attrs, $timeout, FormService, Tag) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            FormService.init(Tag, $scope.id, $scope.model)
            FormService.error_text = "тег уже существует"

        $scope.checkExistance = (field, event) ->
            Tag.checkExistance
                id: FormService.model.id
                text: FormService.model.text
            , (response) ->
                element = $(event.target)
                if response.exists
                    FormService.error_element = element
                    element.addClass('has-error').focus()
                else
                    FormService.error_element = undefined
                    element.removeClass('has-error')

    .controller 'TagsMassEdit', ($scope, $timeout, Tag, Review, Gallery, PricePosition) ->
        bindArguments($scope, arguments)

        Resource = null

        $timeout ->
            switch $scope.class
                when 'App\\Models\\Gallery' then Resource = Gallery
                when 'App\\Models\\Review' then Resource = Review
                when 'App\\Models\\PricePosition' then Resource = PricePosition

        $scope.isChecked = (item) ->
            tag = item.tags.find (t) -> t.id == $scope.tag.id
            return tag isnt undefined
        
        $scope.checkGroup = (item) ->
            item.is_checked = if item.is_checked then false else true
            for _, i of item.items
                if not i.hasOwnProperty('items')
                    i.tags = i.tags.filter (t) -> t.id != $scope.tag.id
                    if item.is_checked then i.tags.push($scope.tag)
                    Resource.update({id: i.id}, {tags: i.tags})
                else
                    $scope.checkGroup(i)

        $scope.check = (item) ->
            if $scope.isChecked(item)
                item.tags = item.tags.filter (t) -> t.id != $scope.tag.id
            else
                item.tags.push($scope.tag)
            Resource.update({id: item.id}, {tags: item.tags})
