angular
    .module 'Egecms'
    .controller 'MastersIndex', ($scope, $attrs, IndexService, Master) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Master, $scope.current_page, $attrs)
    .controller 'MastersForm', ($scope, $attrs, $timeout, $http, FormService, Master, Photo, Tag, PhotoService) ->
        bindArguments($scope, arguments)

        angular.element(document).ready ->
            FormService.init(Master, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Master', $scope.id)

        $scope.massMode = null

        $scope.selectedIds = {
            videos: {}
            reviews: {}
            gallery: {}
        }

        $scope.changeMasterId = null

        $scope.openMassEditDialog = (massMode) ->
            $scope.massMode = massMode
            $scope.changeMasterId = null
            $('#change-master-dialog').modal('show')
        
        $scope.getSelectedIds = (massMode = null) ->
            massMode = $scope.massMode if massMode is null

            ids = []

            Object.entries($scope.selectedIds[massMode]).forEach (entry) ->
                ids.push(entry[0]) if entry[1] is true
            
            return ids.map(Number)
        
        $scope.massChangeMaster = ->
            ids = $scope.getSelectedIds()
            $http.post("/api/#{$scope.massMode}/mass-update", {
                ids: ids,
                payload:
                    master_id: $scope.changeMasterId
            }).then (response) ->
                notifySuccess ids.length + ' успешно обновлено'
                $('#change-master-dialog').modal('hide')
                ids.forEach (id) ->
                    index = $scope.FormService.model[$scope.massMode].findIndex((e) -> e.id is id)
                    $scope.FormService.model[$scope.massMode].splice(index, 1)
                $scope.selectedIds[$scope.massMode] = {}
                $scope.editingReviewId = null
                $scope.$apply()

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
