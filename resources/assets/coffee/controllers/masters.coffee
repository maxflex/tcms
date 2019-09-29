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

        $scope.selectedReviewIds = {} 

        $scope.editingReviewId = null

        $scope.changeMasterId = null

        $scope.openChangeMasterDialog = ->
            $scope.changeMasterId = null
            $('#change-master-dialog').modal('show')
        
        $scope.editReview = (reviewId) ->
            $scope.editingReviewId = reviewId
            $scope.openChangeMasterDialog()
        
        $scope.massReviewEdit = ->
            $scope.editingReviewId = null
            $scope.openChangeMasterDialog()
        
        $scope.getSelectedReviewIds = ->
            ids = []

            Object.entries($scope.selectedReviewIds).forEach (entry) ->
                ids.push(entry[0]) if entry[1] is true
            
            return ids
        
        $scope.changeReviewMaster = ->
            ids = if $scope.editingReviewId isnt null then [$scope.editingReviewId] else $scope.getSelectedReviewIds()
            $http.post('/api/reviews/mass-update', {
                ids: ids,
                payload: {
                    master_id: $scope.changeMasterId
                }
            }).then (response) ->
                notifySuccess ids.length + ' отзывов успешно обновлено'
                $('#change-master-dialog').modal('hide')
                ids.forEach (reviewId) ->
                    index = $scope.FormService.model.reviews.findIndex((e) -> e.id is reviewId)
                    $scope.FormService.model.reviews.splice(index, 1)
                $scope.selectedReviewIds = {}
                $scope.editingReviewId = null
                $scope.$apply()

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
