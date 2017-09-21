angular
    .module 'Egecms'
    .controller 'GalleryIndex', ($scope, $attrs, IndexService, Gallery) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Gallery, $scope.current_page, $attrs)
    .controller 'GalleryForm', ($scope, $attrs, $timeout, FormService, Gallery, PhotoService, Tag) ->
        bindArguments($scope, arguments)

        $scope.version = 1

        angular.element(document).ready ->
            FormService.init(Gallery, $scope.id, $scope.model)
            PhotoService.init(FormService, 'Gallery', $scope.id)

        $scope.preview = ->
            window.open("/img/gallery/#{FormService.model.id}.png", '_blank')

        $scope.edit = ->
            FormService.edit ->
                $scope.version++

        $scope.editOrUpload = (photo_number) ->
            if photo_number > FormService.model.photos.length
                $('#fileupload').click()
            else
                PhotoService.edit(parseInt(photo_number) - 1)

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise

        $scope.$watch 'FormService.model.count', (newVal, oldVal) ->
            $scope.size = {w: 2200, h:1100}
            $scope.size.w = $scope.size.w / newVal
            $scope.ratio = $scope.size.w / $scope.size.h
