angular.module 'Egecms'
    .service 'IndexService', ($rootScope) ->
        this.filter = ->
            $.cookie(this.controller, JSON.stringify(this.search), { expires: 365, path: '/' })
            this.current_page = 1
            this.pageChanged()

        this.max_size = 10

        this.init = (Resource, current_page, attrs, params = {}) ->
            $rootScope.frontend_loading = true
            this.Resource = Resource
            this.current_page = parseInt(current_page)
            this.controller = attrs.ngController.toLowerCase().slice(0, -5)
            this.search = if $.cookie(this.controller) then JSON.parse($.cookie(this.controller)) else {}
            this.params = params
            this.loadPage()

        this.loadPage = ->
            p = {page: this.current_page}
            p.sort = this.sort if this.sort isnt undefined
            p.folder = this.params.folder if this.params.folder
            $.each @params, (key, val) -> p[key] = val
            this.Resource.get p, (response) =>
                this.page = response
                $rootScope.frontend_loading = false

        this.pageChanged = ->
            $rootScope.frontend_loading = true
            this.loadPage()
            this.changeUrl()

        this.delete = (id, text) ->
            bootbox.confirm "Вы уверены, что хотите удалить #{text} ##{id}?", (result) =>
                if result is true
                    @Resource.delete {id: id}, -> location.reload()

        # change browser user / history push
        this.changeUrl = ->
            window.history.pushState('', '', this.controller + '?page=' + this.current_page)

        this
    .service 'FormService', ($rootScope, $q, $timeout) ->
        this.init = (Resource, id, model) ->
            this.dataLoaded = $q.defer()
            $rootScope.frontend_loading = true
            this.Resource = Resource
            this.saving = false
            if id
                this.model = Resource.get({id: id}, => modelLoaded())
            else
                this.model = new Resource(model)
                modelLoaded()


        modelLoaded = =>
            $rootScope.frontend_loading = false
            $timeout =>
                this.dataLoaded.resolve(true)
                $('.selectpicker').selectpicker 'refresh'

        beforeSave = =>
            # если нет ошибок, вернуть true и обработать в save/create
            if this.error_element is undefined
                ajaxStart()
                this.beforeSave() if this.beforeSave isnt undefined
                this.saving = true
                true
            else
                $(this.error_element).focus()
                notifyError(this.error_text) if this.error_text isnt undefined
                false

        # вырезаем MODEL из url типа /website/model/create
        modelName = ->
            l = window.location.pathname.split('/')
            model_name = l[l.length - 2]
            model_name = l[l.length - 3] if $.isNumeric(model_name)
            model_name

        this.delete = (event, callback = false) ->
            bootbox.confirm "Вы уверены, что хотите #{$(event.target).text()} ##{this.model.id}?", (result) =>
                if result is true
                    beforeSave()
                    this.model.$delete().then =>
                        if callback #static deletion
                            callback()
                            this.saving = false
                            ajaxEnd()
                        else
                            url = @redirect_url || modelName()
                            url = @prefix + url if @prefix
                            redirect url
                    , (response) ->
                        notifyError response.data.message

        this.edit = (callback = null) ->
            return if not beforeSave()
            this.model.$update().then =>
                callback() if callback isnt null
                this.saving = false
                ajaxEnd()
            , (response) ->
                notifyError response.data.message
                this.saving = false
                ajaxEnd()

        this.create = ->
            return if not beforeSave()
            this.model.$save().then (response) =>
                url = @redirect_url || modelName() + "/#{response.id}/edit"
                url = @prefix + url if @prefix
                redirect url
            , (response) =>
                notifyError response.data.message
                this.saving = false
                ajaxEnd()
                this.onCreateError(response)

        this
