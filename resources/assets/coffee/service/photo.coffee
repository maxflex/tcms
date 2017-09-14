angular.module 'Egecms'
    .service 'PhotoService', ($rootScope, $http, Photo) ->
        this.image = ''
        this.cropped_image = ''
        this.cripping = false
        this.FormService = null
        this.selected_photo_index = null

        this.init = (FormService, type, id) =>
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
            maxFileSize: 10000000, # 10 MB
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
                @FormService.model.photos.push(response.result)
                @edit(@FormService.model.photos.length - 1)
                $rootScope.$apply()
            ,

        this.getSelectedPhoto = -> @FormService.model.photos[@selected_photo_index]

        this.edit = (index) ->
            @selected_photo_index = index
            @image = @getSelectedPhoto().original_url
            $('#change-photo').modal('show')

        this.delete = ->
            Photo.delete({id: @getSelectedPhoto().id})
            @FormService.model.photos.splice(@selected_photo_index, 1)
            $('#change-photo').modal('hide')

        this
