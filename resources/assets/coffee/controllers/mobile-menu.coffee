angular
    .module 'Egecms'
    .controller 'MobileMenuIndex', ($rootScope, $scope, $timeout, $http, MobileMenu) ->
        bindArguments($scope, arguments)

        $scope.sections = null
        $scope.dialogItem = {}

        loadData = ->
            ajaxStart()
            $http.get 'api/mobile-menu-sections'
            .then (r) -> 
                $scope.sections = r.data
                ajaxEnd()


        $timeout ->
            $scope.collapsedMobileMenu = if $.cookie("collapsedMobileMenu") then JSON.parse($.cookie("collapsedMobileMenu")) else []
            $scope.collapsedMobileMenuSection = if $.cookie("collapsedMobileMenuSection") then JSON.parse($.cookie("collapsedMobileMenuSection")) else []
            loadData()

        $scope.openDialog = (item = {}, id = 'menu-item-dialog') ->
            $scope.dialogItem = _.clone(item)
            $('#' + id).modal('show')
        
        $scope.save = ->
            if $scope.dialogItem.id
                MobileMenu.update($scope.dialogItem, (r) -> loadData()) 
            else
                MobileMenu.save($scope.dialogItem, (r) -> loadData()) 
            $('#menu-item-dialog').modal('hide')
        
        $scope.remove = (id) ->
            bootbox.confirm 'Вы уверены, что хотите удалить пункт меню?', (result) ->
                MobileMenu.remove({id: id}, (r) -> loadData()) if result is true
        
         $scope.removeSection = (id) ->
            bootbox.confirm 'Вы уверены, что хотите удалить раздел?', (result) ->
                $http.delete('api/mobile-menu-sections/' + id).then((r) -> loadData()) if result is true

        $scope.saveSection = ->
            if $scope.dialogItem.id
                $http.put 'api/mobile-menu-sections/' + $scope.dialogItem.id, $scope.dialogItem
                .then (r) -> loadData()
            else
                $http.post 'api/mobile-menu-sections', $scope.dialogItem
                .then (r) -> loadData()
            $('#menu-section-dialog').modal('hide')

        $scope.sortableOptions =
            update: (event, ui) ->
                $timeout ->
                    $scope.sections.forEach (section, index) ->
                        section.items.forEach (item, index) ->
                            MobileMenu.update({id: item.id, position: index})
            items: '.menu-item'
            axis: 'y'
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999

        $scope.sortableOptionsSections =
            update: (event, ui) ->
                $timeout ->
                    $scope.sections.forEach (section, index) ->
                        $http.put 'api/mobile-menu-sections/' + section.id, {position: index}
            items: '.mobile-menu-section'
            axis: 'y'
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
        
        $scope.toggleCollapse = (item) ->
            id = item.id
            if id in $scope.collapsedMobileMenu
                $scope.collapsedMobileMenu = _.without($scope.collapsedMobileMenu, id)
            else
                $scope.collapsedMobileMenu.push(id)
            $.cookie("collapsedMobileMenu", JSON.stringify($scope.collapsedMobileMenu), { expires: 365, path: '/' })

        $scope.isCollapsed = (item) -> item.id in $scope.collapsedMobileMenu

        $scope.toggleCollapseSection = (item) ->
            id = item.id
            if id in $scope.collapsedMobileMenuSection
                $scope.collapsedMobileMenuSection = _.without($scope.collapsedMobileMenuSection, id)
            else
                $scope.collapsedMobileMenuSection.push(id)
            $.cookie("collapsedMobileMenuSection", JSON.stringify($scope.collapsedMobileMenuSection), { expires: 365, path: '/' })

        $scope.isCollapsedSection = (item) -> item.id in $scope.collapsedMobileMenuSection