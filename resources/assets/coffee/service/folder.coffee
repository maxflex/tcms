angular.module 'Egecms'
    .service 'FolderService', ($http, $timeout, Folder) ->
        @folders = []
        @parent_folder = null

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
            @IndexService = IndexService
            @Resource = Resource
            @parent_folder = Folder.get({id: current_folder_id}) if current_folder_id
            @folders = Folder.query
                class: modelClass
                current_folder_id: current_folder_id
                # save_visited_folder_id: current_folder_id isnt undefined # сохранять ли посещенную ID папки

            , -> spRefresh()
            @modal = $(config.modalId)

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

        @editModal = (folder) ->
            @popup_folder = _.clone(folder)
            @modal.modal('show')

        @edit = ->
            Folder.update(@popup_folder)
            @modal.modal('hide')
            if @popup_folder.id then @folders.forEach (folder, i) =>
                @folders[i] = _.clone(@popup_folder) if folder.id == @popup_folder.id

        @delete = (folder) ->
            bootbox.confirm "Вы уверены, что хотите удалить папку «#{folder.name}»?", (result) =>
                if result is true
                    Folder.delete {id: folder.id}, -> location.reload()

        @isEmpty = (folder) -> not folder.item_count && not folder.folder_count

        @