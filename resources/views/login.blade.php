<!DOCTYPE html>
<html>
  <head>
    <title>Ателье «Талисман» | Вход</title>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta charset="utf-8">
    <base href="{{ config('app.url') }}">
    <link href="{{ asset('css/app.css', isProduction()) }}" rel="stylesheet" type="text/css">
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:700" rel="stylesheet"> --}}
    <link href="css/signin.css" rel="stylesheet" type="text/css">
    @yield('scripts')

    <script src="{{ asset('/js/vendor.js', isProduction()) }}"></script>
    <script src="{{ config('app.url') }}{{ elixir('js/app.js', isProduction()) }}"></script>
  </head>

  <body class="content animated fadeIn" ng-app="Egecms" ng-controller="LoginCtrl"
    ng-init='wallpaper = {{ json_encode($wallpaper) }}'>
      <div ng-show="image_loaded">
          @yield('content')
      </div>
      <div ng-show="!image_loaded">
          <img src="/img/svg/tail-spin.svg" />
      </div>
  </body>

</html>
