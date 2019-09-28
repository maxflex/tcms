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

        $scope.changeMasterId = null

        $scope.openChangeMasterDialog = ->
            $('#change-master-dialog').modal('show')
        
        $scope.getSelectedReviewIds = ->
            ids = []

            Object.entries($scope.selectedReviewIds).forEach (entry) ->
                ids.push(entry[0]) if entry[1] is true
            
            return ids
        
        $scope.changeReviewMaster = ->
            $http.post('/api/reviews/mass-update', {
                ids: $scope.getSelectedReviewIds(),
                payload: {
                    master_id: $scope.changeMasterId
                }
            }).then (response) ->
                notifySuccess $scope.getSelectedReviewIds().length + ' отзывов успешно обновлено'
                $('#change-master-dialog').modal('hide')
                $scope.getSelectedReviewIds().forEach (reviewId) ->
                    index = $scope.FormService.model.reviews.findIndex((e) -> e.id is reviewId)
                    $scope.FormService.model.reviews.splice(index, 1)
                $scope.FormService.model.reviews
                $scope.selectedReviewIds = {}
                $scope.$apply()

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise
