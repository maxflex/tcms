angular.module 'Egecms'
    .service 'PhotoService', ($rootScope, $http, $timeout, Photo) ->
        this.image = ''
        this.cropped_image = ''
        this.cripping = false
        this.watermark = false
        this.aspect_ratio = null
        this.FormService = null
        this.methods = {}
        this.selected_photo_index = null

        this.init = (FormService, type, id, afterDone = null) =>
            @type = type
            @id = id
            @FormService = FormService
            @afterDone = afterDone
            @bindFileUpload(type, id)

        this.crop = ->
            @cropping = true
            # именно так
            $timeout => @methods.updateResultImage => $timeout =>
                fd = new FormData()
                blob = dataURItoBlob(@cropped_image)
                fd.append('cropped_image', blob)
                fd.append('id', @getSelectedPhoto().id)
                fd.append('watermark', @watermark)

                # @methods.getResultImageDataBlob().then (blob) ->
                console.log('blob', blob)

                # return
                $http.post 'upload/cropped', fd,
                    transformRequest: angular.identity
                    headers: {'Content-Type': undefined}
                .then (response) =>
                    @cropping = false
                    @FormService.model.photos[@selected_photo_index] = response.data
                    @closeModal()
                , (error) =>
                    @cropping = false
                    notifyError("Ошибка при загрузке")


        this.closeModal = -> $('#change-photo').modal('hide')

        this.bindFileUpload = (type, id) ->
          # загрузка файла договора
          $('#fileupload').fileupload
            formData:
                id: id
                type: type
            # maxFileSize: 10000000, # 10 MB
            # начало загрузки
            send: ->
              NProgress.configure({ showSpinner: true })
            ,
            # во время загрузки
            progress: (e, data) ->
                NProgress.set(data.loaded / data.total)
            ,
            # всегда по окончании загрузки (неважно, ошибка или успех)
            always: ->
                NProgress.configure({ showSpinner: false })
                ajaxEnd()
            ,
            done: (i, response) =>
                if response.result.hasOwnProperty('error')
                    notifyError(response.result.error)
                    return
                if @photo_id
                    @FormService.model.photos[@selected_photo_index] = response.result
                    @image = @getSelectedPhoto().original_url
                    delete @photo_id
                else
                    @FormService.model.photos.push(response.result)
                    @edit(@FormService.model.photos.length - 1)
                @afterDone(response.result) if typeof @afterDone is 'function'
                $rootScope.$apply()


        this.getSelectedPhoto = -> @FormService.model.photos[@selected_photo_index]

        this.loadNew = ->
            @photo_id = @getSelectedPhoto().id
            $('#fileupload').bind 'fileuploadsubmit', (e, data) =>
                data.formData =
                    id: @id
                    type: @type
                    photo_id: @photo_id
                    count: @FormService.model.count
            $('#fileupload').click()

        this.edit = (index) ->
            @selected_photo_index = index
            @image = @getSelectedPhoto().original_url
            $('#change-photo').modal('show')

        this.delete = ->
            Photo.delete({id: @getSelectedPhoto().id})
            @FormService.model.photos.splice(@selected_photo_index, 1)
            $('#change-photo').modal('hide')

        this.toggleAscpectRatio = ->
            console.log('aspect ratio')
            if @aspect_ratio is null
                @aspect_ratio = 7 / 4
            else
                @aspect_ratio = null

        this
