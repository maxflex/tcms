angular
    .module 'Egecms'
    .controller 'LoginCtrl', ($scope, $http) ->

        loadImage = ->
            $scope.image_loaded = false
            img = new Image
            img.addEventListener "load", ->
                $('body').css({'background-image': "url(#{$scope.wallpaper.image_url})"})
                $scope.image_loaded = true
                $scope.$apply()
                setTimeout ->
                    $('#center').removeClass('animated').removeClass('fadeIn').removeAttr('style')
                , 2000
            img.src = $scope.wallpaper.image_url

        angular.element(document).ready ->
            loadImage()
            $('input[autocomplete="off"]').each ->
                input = this
                id = $(input).attr('id')
                $(input).removeAttr('id')
                setTimeout ->
                    $(input).attr('id', id)
                , 2000
            $scope.l = Ladda.create(document.querySelector('#login-submit'))
            login_data = $.cookie("login_data")
            if login_data isnt undefined
                login_data = JSON.parse(login_data)
                $scope.login = login_data.login
                $scope.password = login_data.password
                $scope.sms_verification = true
                $scope.$apply()

        #обработка события по enter в форме логина
        $scope.enter = ($event) ->
            if $event.keyCode == 13
                $scope.checkFields()

        $scope.goLogin = ->
            # $('center').removeClass('invalid')
            $http.post 'login',
                login: $scope.login
                password: $scope.password
                code: $scope.code
                # captcha: grecaptcha.getResponse()
            .then (response) ->
                # grecaptcha.reset()
                if response.data is true
                    $.removeCookie('login_data')
                    location.reload()
                else if response.data is 'sms'
                    $scope.in_process = false
                    $scope.l.stop()
                    $scope.sms_verification = true
                    $.cookie("login_data", JSON.stringify({login: $scope.login, password: $scope.password}), { expires: 1 / (24 * 60) * 2, path: '/' })
                else
                    $scope.in_process = false
                    $scope.l.stop()
                    $scope.error = "Неправильная пара логин-пароль"
                    # $('center').addClass('invalid')
                $scope.$apply()

        $scope.checkFields = ->
            $scope.l.start()
            $scope.in_process = true
            $scope.goLogin()
            # if grecaptcha.getResponse() is '' then grecaptcha.execute() else $scope.goLogin()
