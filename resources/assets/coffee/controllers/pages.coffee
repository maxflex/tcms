angular
    .module 'Egecms'
    .controller 'PagesIndex', ($scope, $attrs, $timeout, IndexService, Page, Published, FolderService) ->
        bindArguments($scope, arguments)
        angular.element(document).ready ->
            IndexService.init(Page, $scope.current_page, $attrs, {folder: $scope.folder})
            FolderService.init($scope.template.class, $scope.folder, IndexService, Page)
    .controller 'PagesForm', ($scope, $http, $attrs, $timeout, FormService, AceService, Page, Published, UpDown, PageItem, Tag, FolderService) ->
        bindArguments($scope, arguments)

        empty_useful = {text: null, page_id_field: null}

        $scope.copy = ->
            ajaxStart()
            $http.post 'api/pages/copy', {id: $scope.id}
            .then (response) ->
                console.log(response)
                redirect("pages/#{response.data}/edit")

        angular.element(document).ready ->
            FolderService.init($scope.template.class)
            FormService.init(Page, $scope.id, $scope.model)
            FormService.model.folder_id = $.cookie('page_folder_id') if not FormService.model.id && $.cookie('page_folder_id')
            FormService.dataLoaded.promise.then ->
                FormService.model.useful = [angular.copy(empty_useful)] if (not FormService.model.useful or not FormService.model.useful.length)
                ['html', 'html_mobile', 'seo_text'].forEach (field) -> AceService.initEditor(FormService, 15, "editor--#{field}")
            FormService.beforeSave = ->
                ['html', 'html_mobile', 'seo_text'].forEach (field) -> FormService.model[field] = AceService.getEditor("editor--#{field}").getValue()
                if FormService.model.items then FormService.model.items.forEach (item, index) ->
                    item.href_page_id = null if not item.href_page_id
                    PageItem.update {id: item.id}, item,  ->
                        console.log('updated')
                    , ->
                        ajaxEnd()
                        notifyError 'Несуществующий номер раздела'
            bindFileUpload()

        $scope.generateUrl = (event) ->
            $http.post '/api/translit/to-url',
                text: FormService.model.keyphrase
            .then (response) ->
                FormService.model.url = response.data
                $scope.checkExistance 'url',
                    target: $(event.target).closest('div').find('input')

        $scope.checkExistance = (field, event) ->
            Page.checkExistance
                id: FormService.model.id
                field: field
                value: FormService.model[field]
            , (response) ->
                element = $(event.target)
                if response.exists
                    FormService.error_element = element
                    element.addClass('has-error').focus()
                else
                    FormService.error_element = undefined
                    element.removeClass('has-error')

        # @todo: объединить с checkExistance
        $scope.checkUsefulExistance = (field, event, value) ->
            Page.checkExistance
                id: FormService.model.id
                field: field
                value: value
            , (response) ->
                element = $(event.target)
                if not value or response.exists
                    FormService.error_element = undefined
                    element.removeClass('has-error')
                else
                    FormService.error_element = element
                    element.addClass('has-error').focus()

        $scope.addUseful = ->
            FormService.model.useful.push(angular.copy(empty_useful))

        $scope.addLinkDialog = ->
            $scope.link_text = AceService.editor.getSelectedText()
            $('#link-manager').modal 'show'

        $scope.search = (input, promise)->
            $http.post('api/pages/search', {q: input}, {timeout: promise})
                .then (response) ->
                    return response

        $scope.searchSelected = (selectedObject) ->
            $scope.link_page_id = selectedObject.originalObject.id
            $scope.$broadcast('angucomplete-alt:changeInput', 'page-search', $scope.link_page_id.toString())

        $scope.addLink = ->
            link = "<a href='[link|#{$scope.link_page_id}]'>#{$scope.link_text}</a>"
            $scope.link_page_id = undefined
            $scope.$broadcast('angucomplete-alt:clearInput')
            AceService.editor.session.replace(AceService.editor.selection.getRange(), link)
            $('#link-manager').modal 'hide'

        $scope.$watch 'FormService.model.station_id', (newVal, oldVal) ->
            $timeout -> $('#sort').selectpicker('refresh')

        $scope.sortableOptions =
            handle: ".photo-dashed"
            items: ".page-item-draggable"
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            containment: "parent"
            tolerance: "pointer"

        $scope.addService = ->
            PageItem.save
                page_id: FormService.model.id
            , (response) ->
                FormService.model.items.push(response)

        $scope.removeService = (item) ->
            PageItem.delete({id: item.id})
            FormService.model.items = _.filter FormService.model.items, (i) -> i.id != item.id

        $scope.uploadSvg = (item) ->
            console.log(item)
            $scope.selected_item = item
            $timeout -> $('#fileupload').click()

        $scope.togglePublished = ->
            FormService.model.published = not FormService.model.published
            FormService.model.published = if FormService.model.published then 1 else 0

        $scope.loadTags = (text) ->
            Tag.autocomplete({text: text}).$promise

        bindFileUpload = ->
          # загрузка файла договора
          $('#fileupload').fileupload
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
                $scope.selected_item.file = response.result
                $scope.$apply()
                console.log(response.result)
