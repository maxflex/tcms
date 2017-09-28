angular.module('Egecms')
    .factory 'Variable', ($resource) ->
        $resource apiPath('variables'), {id: '@id'}, updatable()

    .factory 'VariableGroup', ($resource) ->
        $resource apiPath('variables/groups'), {id: '@id'}, updatable()

    .factory 'PageGroup', ($resource) ->
        $resource apiPath('pages/groups'), {id: '@id'}, updatable()

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
        $resource apiPath('gallery'), {id: '@id'}, updatable()

    .factory 'Photo', ($resource) ->
        $resource apiPath('photos'), {id: '@id'}, updatable()

    .factory 'PageItem', ($resource) ->
        $resource apiPath('pageitems'), {id: '@id'}, updatable()

    .factory 'User', ($resource) ->
        $resource apiPath('users'), {id: '@id'}, updatable()

    .factory 'Tag', ($resource) ->
        $resource apiPath('tags'), {id: '@id'},
                update:
                    method: 'PUT'
                autocomplete:
                    method: 'GET'
                    url: apiPath('tags', 'autocomplete')
                    isArray: true

    .factory 'Master', ($resource) ->
        $resource apiPath('masters'), {id: '@id'}, updatable()

    .factory 'Review', ($resource) ->
        $resource apiPath('reviews'), {id: '@id'}, updatable()


apiPath = (entity, additional = '') ->
    "api/#{entity}/" + (if additional then additional + '/' else '') + ":id"


updatable = ->
    update:
        method: 'PUT'
countable = ->
    count:
        method: 'GET'
