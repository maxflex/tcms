angular.module 'Egecms'
    .service 'FolderService', ($http, $timeout, Folder) ->
        @folders = []

        @breadcrumbs = null

        @itemSortableOptions =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) =>
                $timeout =>
                    @IndexService.page.data.forEach (model, index) =>
                        @Resource.update({id: model.id, position: index})

        @folderSortableOptions =
            cursor: "move"
            opacity: 0.9,
            zIndex: 9999
            tolerance: "pointer"
            axis: 'y'
            update: (event, ui) =>
                $timeout =>
                    @folders.forEach (model, index) ->
                        Folder.update({id: model.id, position: index})

        config =
            modalId: '#folder-modal'

        @init = (modelClass, current_folder_id, IndexService, Resource) ->
            @class = modelClass
            @current_folder_id = current_folder_id
            @current_folder = Folder.get({id: current_folder_id})
            @IndexService = IndexService
            @Resource = Resource
            @breadcrumbs = Folder.breadcrumbs({id: current_folder_id}) if current_folder_id
            if not IndexService then Folder.tree {class: modelClass}, (response) =>
                @tree = getTree(response)
                $timeout => $('.folder-selectpicker').selectpicker('refresh')

            @folders = Folder.query
                class: modelClass
                current_folder_id: current_folder_id
                save_visited_folder_id: current_folder_id isnt undefined # сохранять ли посещенную ID папки

            , -> spRefresh()
            @modal = $(config.modalId)

        # получить все папки с уровнями
        getTree = (folders, level = 0, parent_name = null) ->
            items = []
            folders.forEach (item) =>
                name = ''
                name += "<span class='subfolders'>#{parent_name} / </span>" if parent_name
                name += item.name
                items.push
                    id: item.id
                    name: name
                    level: level
                items = items.concat(getTree(item.folders, level + 1, name)) if item.folders
            items

        @createModal = ->
            @popup_folder = {name: null}
            @modal.modal('show')

        @createOrUpdate = ->
            @modal.modal('hide')
            if @popup_folder.id then @edit() else @create()

        @create = ->
            Folder.save
                class: @class
                name: @popup_folder.name
                folder_id: @current_folder_id
            , (response) =>
                @folders.push(response)

        @editModal = ->
            # @popup_folder = _.clone(folder)
            @popup_folder = @current_folder
            @modal.modal('show')

        @edit = ->
            Folder.update(@popup_folder)
            @modal.modal('hide')
            if @popup_folder.id then @folders.forEach (folder, i) =>
                @folders[i] = _.clone(@popup_folder) if folder.id == @popup_folder.id

        @delete = (folder) ->
            bootbox.confirm "Вы уверены, что хотите удалить папку «#{@current_folder.name}»?", (result) =>
                if result is true
                    Folder.delete {id: @current_folder.id}, -> history.back()

        @isEmpty = (folder) -> not folder.item_count && not folder.folder_count

        @
