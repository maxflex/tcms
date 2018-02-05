angular
    .module 'Egecms'
    .controller 'GalleryIndex', ($scope, $attrs, $timeout, IndexService, Gallery, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Gallery, $scope.current_page, $attrs, {folder: $scope.folder})
            FolderService.init($scope.template.class, $scope.folder, IndexService, Gallery)
    .controller 'GalleryForm', ($scope, $attrs, $timeout, FormService, Gallery, PhotoService, Tag, FolderService) ->
        bindArguments($scope, arguments)

        $scope.version = makeId()

        angular.element(document).ready ->
            FolderService.init($scope.template.class)
            FormService.init(Gallery, $scope.id, $scope.model)
            FormService.model.folder_id = $.cookie('gallery_folder_id') if not FormService.model.id && $.cookie('gallery_folder_id')
            # PhotoService.afterSave = $scope.edit
            PhotoService.init(FormService, 'Gallery', $scope.id)

        $scope.preview = ->
            window.open("/img/gallery/#{FormService.model.id}.jpg?v=" + makeId(), '_blank')

        $scope.edit = ->
            FormService.edit ->
                $scope.version = makeId()

        $scope.editOrUpload = (photo_number) ->
            if photo_number > FormService.model.photos.length
                $('#fileupload').click()
            else
                PhotoService.edit(parseInt(photo_number) - 1)

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise

        $scope.getTotalPrice = ->
            total_price = 0
            [1, 2, 3, 4, 5, 6].forEach (i) ->
                price = parseInt(FormService.model["price_#{i}"])
                total_price += price if price
            total_price

        $scope.$watch 'FormService.model.count', (newVal, oldVal) ->
            $scope.size = {w: 2200, h:1100}
            $scope.size.w = $scope.size.w / newVal
            $scope.ratio = $scope.size.w / $scope.size.h
            $('#fileupload').bind 'fileuploadsubmit', (e, data) =>
                data.formData =
                    id: FormService.model.id
                    type: 'Gallery'
                    count: FormService.model.count
