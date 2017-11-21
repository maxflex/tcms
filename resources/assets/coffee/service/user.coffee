angular.module 'Egecms'
    .service 'UserService', (User, $rootScope, $timeout)->
        # load all users
        this.users = User.query()

        # logged user
        $timeout =>
            this.current_user = $rootScope.$$childTail.user

        # system user
        system_user =
            color: '#999999'
            login: 'system'
            id: 0

        this.get = (user_id) ->
            this.getUser(user_id)

        this.getUser = (user_id) ->
            _.findWhere(this.users, {id: parseInt(user_id)}) or system_user

        this.getLogin = (user_id) ->
            this.getUser(parseInt(user_id)).login

        this.getColor = (user_id) ->
            this.getUser(parseInt(user_id)).color

        this.getWithSystem = (only_active = true) ->
            users = this.getAll(only_active)
            users.unshift system_user
            users

        this.getAll = (only_active = true) ->
            if only_active
                _.filter @users, (user) ->
                    user.rights.length && user.rights.indexOf('35') is -1
            else
                this.users

        this.toggle = (entity, user_id, Resource = false) ->
            new_user_id = if entity[user_id] then 0 else this.current_user.id

            if Resource
                Resource.update
                    id: entity.id
                    "#{user_id}": new_user_id
                , ->
                    entity[user_id] = new_user_id
            else
                entity[user_id] = new_user_id

        this.getBannedUsers = ->
            _.filter @users, (user) ->
                user.rights.length and user.rights.indexOf('35') isnt -1

        this.getBannedHaving = (condition_obj) ->
            _.filter this.users, (user) ->
                user.rights.indexOf('35') isnt -1 and condition_obj and condition_obj[user.id]

        this.getActiveInAnySystem = (with_system = true) ->
            users = _.chain(@users).filter (user) ->
                user.rights.indexOf('35') is -1 or user.rights.indexOf('34') is -1
            .sortBy('login').value()
            users.unshift system_user if with_system
            users

        this.getBannedInBothSystems = ->
            _.chain(@users).filter (user) ->
                user.rights.indexOf('35') isnt -1 and user.rights.indexOf('34') isnt -1
            .sortBy('login').value()

        this
