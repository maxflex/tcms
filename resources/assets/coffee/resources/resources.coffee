angular.module('Egecms')
    .factory 'Variable', ($resource) ->
        $resource apiPath('variables'), {id: '@id'}, updatable()

    .factory 'VariableGroup', ($resource) ->
        $resource apiPath('variables/groups'), {id: '@id'}, updatable()

    .factory 'Page', ($resource) ->
        $resource apiPath('pages'), {id: '@id'},
            update:
                method: 'PUT'
            checkExistance:
                method: 'POST'
                url: apiPath('pages', 'checkExistance')

    .factory 'Equipment', ($resource) ->
        $resource apiPath('equipment'), {id: '@id'}, updatable()

    .factory 'PriceSection', ($resource) ->
        $resource apiPath('prices'), {id: '@id'}, updatable()

    .factory 'PricePosition', ($resource) ->
        $resource apiPath('prices/positions'), {id: '@id'}, updatable()

    .factory 'Gallery', ($resource) ->
        $resource apiPath('galleries'), {id: '@id'}, updatable()

    .factory 'Photo', ($resource) ->
        $resource apiPath('photos'), {id: '@id'}, updatable()

    .factory 'Folder', ($resource) ->
        $resource apiPath('folders'), {id: '@id'},
            update:
                method: 'PUT'
            tree:
                method: 'POST'
                url: apiPath('folders', 'tree')
                isArray: true
            breadcrumbs:
                method: 'GET'
                url: apiPath('folders', 'breadcrumbs')
                isArray: true

    .factory 'PageItem', ($resource) ->
        $resource apiPath('pageitems'), {id: '@id'}, updatable()

    .factory 'User', ($resource) ->
        $resource apiPath('users'), {id: '@id'}, updatable()

    .factory 'AllUser', ($resource) ->
        $resource apiPath('allusers'), {id: '@id'}, updatable()

    .factory 'Payment', ($resource) ->
        $resource apiPath('payments'), {id: '@id'}, updatable()

    .factory 'PaymentSource', ($resource) ->
        $resource apiPath('payments/sources'), {id: '@id'}, updatable()

    .factory 'PaymentExpenditure', ($resource) ->
        $resource apiPath('payments/expenditures'), {id: '@id'}, updatable()

    .factory 'PaymentExpenditureGroup', ($resource) ->
        $resource apiPath('payments/expendituregroups'), {id: '@id'}, updatable()

    .factory 'Tag', ($resource) ->
        $resource apiPath('tags'), {id: '@id'},
                update:
                    method: 'PUT'
                autocomplete:
                    method: 'GET'
                    url: apiPath('tags', 'autocomplete')
                    isArray: true
                checkExistance:
                    method: 'POST'
                    url: apiPath('tags', 'checkExistance')

    .factory 'Master', ($resource) ->
        $resource apiPath('masters'), {id: '@id'}, updatable()

    .factory 'Review', ($resource) ->
        $resource apiPath('reviews'), {id: '@id'}, updatable()

    .factory 'Menu', ($resource) ->
        $resource apiPath('menu'), {id: '@id'}, updatable()

    .factory 'Video', ($resource) ->
        $resource apiPath('videos'), {id: '@id'}, updatable()


apiPath = (entity, additional = '') ->
    "api/#{entity}/" + (if additional then additional + '/' else '') + ":id"


updatable = ->
    update:
        method: 'PUT'
countable = ->
    count:
        method: 'GET'
