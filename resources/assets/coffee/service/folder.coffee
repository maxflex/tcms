angular.module 'Egecms'
    .service 'FolderService', ($http, $timeout, Folder) ->
        @folders = []

        @sortableOptions =
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

        @init = (modelClass, current_folder) ->
            @class = modelClass
            @current_folder = current_folder
            @folders = Folder.query
                class: modelClass
                current_folder: current_folder
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
                folder_id: @current_folder
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

        @