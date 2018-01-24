angular.module 'Egecms'
    .service 'FolderService', ($http) ->
        this.get = (table, select = null, orderBy = null)->
            $http.post 'api/factory',
                table: table
                select: select
                orderBy: orderBy

        this
