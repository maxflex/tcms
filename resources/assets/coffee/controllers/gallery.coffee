angular
    .module 'Egecms'
    .controller 'GalleryIndex', ($scope, $attrs, $timeout, IndexService, Gallery, GalleryFolder) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Gallery, $scope.current_page, $attrs, {folder_id: $scope.folder_id})
            folders = []
            $.each $scope.folders, (index, folder) ->
                folders.push(folder)
            $scope.folders = folders

        $scope.sortableOptions =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) ->
                $timeout ->
                    IndexService.page.data.forEach (model, index) ->
                        Gallery.update({id: model.id, position: index})

        $scope.sortableOptionsFolder =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) ->
                $timeout ->
                    $scope.folders.forEach (model, index) ->
                        GalleryFolder.update({id: model.id, position: index})

        $scope.editFolderPopup = (folder) ->
            $scope.popup_folder = folder
            $scope.popup_folder_name = folder.name
            $('#edit-folder').modal('show')

        $scope.editFolder = ->
            $scope.popup_folder.name = $scope.popup_folder_name
            GalleryFolder.update($scope.popup_folder)
            $('#edit-folder').modal('hide')

        $scope.deleteFolder = (folder) ->
            bootbox.confirm "Вы уверены, что хотите удалить папку «#{folder.name}»?", (result) =>
                if result is true
                    GalleryFolder.delete {id: folder.id}, -> location.reload()

    .controller 'GalleryForm', ($scope, $attrs, $timeout, FormService, Gallery, PhotoService, Tag, GalleryFolder) ->
        bindArguments($scope, arguments)

        $scope.version = makeId()

        angular.element(document).ready ->
            FormService.init(Gallery, $scope.id, $scope.model)
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

        $scope.changeFolder = ->
            if FormService.model.folder_id is -1
                FormService.model.folder_id = ''
                $('#new-folder').modal('show')
            # console.log(FormService.model.folder_id)

        $scope.createNewFolder = ->
            $('#new-folder').modal('hide')
            GalleryFolder.save
                name: $scope.new_folder_name
            , (response) ->
                $scope.new_folder_name = ''
                $scope.folders[makeId()] = response
                FormService.model.folder_id = response.id
                $timeout -> $('.selectpicker').selectpicker('refresh')

        $scope.$watch 'FormService.model.count', (newVal, oldVal) ->
            $scope.size = {w: 2200, h:1100}
            $scope.size.w = $scope.size.w / newVal
            $scope.ratio = $scope.size.w / $scope.size.h
            $('#fileupload').bind 'fileuploadsubmit', (e, data) =>
                data.formData =
                    id: FormService.model.id
                    type: 'Gallery'
                    count: FormService.model.count
