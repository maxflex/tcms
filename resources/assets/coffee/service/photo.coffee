angular.module 'Egecms'
    .service 'PhotoService', ($rootScope, $http, Photo) ->
        this.image = ''
        this.cropped_image = ''
        this.cripping = false
        this.aspect_ratio = null
        this.FormService = null
        this.selected_photo_index = null

        this.init = (FormService, type, id) =>
            @type = type
            @id = id
            @FormService = FormService
            @bindFileUpload(type, id)

        this.crop = ->
            @cropping = true
            $http.post 'upload/cropped',
                id: @getSelectedPhoto().id
                cropped_image: @cropped_image
            .then (response) =>
                @cropping = false
                @FormService.model.photos[@selected_photo_index] = response.data
                $('#change-photo').modal('hide')

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
                # @afterDone() if typeof @afterDone is 'function'
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
                @aspect_ratio = 2
            else
                @aspect_ratio = null

        this
