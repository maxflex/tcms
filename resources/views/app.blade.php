<!DOCTYPE html>
<html>
  <head>
    <title>Ательер-Талисман</title>
    <meta charset="utf-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta charset="utf-8">
    <base href="{{ config('app.url') }}">
    <link href="css/app.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="favicon.png?v=2" />
    <link rel="sitemap" href="sitemap.xml">
    {{-- <link href='https://fonts.googleapis.com/css?family=Ubuntu&subset=latin,cyrillic' rel='stylesheet' type='text/css'> --}}
    @yield('scripts')
    <script src="{{ asset('/js/vendor.js', true) }}"></script>
    <script src="{{ asset('/js/app.js', true) }}"></script>
    @yield('scripts_after')
    @include('server_variables')
	
	<!-- Google.Analytics counter -->     
	<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-29237086-2', 'auto'); ga('send', 'pageview'); </script>
	<!-- /Google.Analytics counter -->
  </head>
  <body class="content" ng-app="Egecms" ng-controller="@yield('controller')"
        ng-init='user = {{ $user }};
        @if (isset($nginit))
            {{ $nginit }}
        @endif
    '>
    <div class="row">
      <div style="margin-left: 10px" class="col-sm-2">
          <div class="list-group">
              @include('_menu')
          </div>
      </div>
      <div style="padding: 0; width: 80.6%;" class="col-sm-9 content-col">
        <div class="panel panel-primary">
          <div class="panel-heading panel-heading-main">
              <div class="row">
                  <div class="col-sm-4">@yield('title')</div>
                  <div class="col-sm-4 center">
                      @yield('title-center')
                  </div>
                  <div class="col-sm-4 right">
                      @yield('title-right')
                  </div>
              </div>

          </div>
          <div class="panel-body panel-frontend-loading">
              <div class="frontend-loading animate-fadeIn" ng-show='frontend_loading'>
                  <span>загрузка...</span>
              </div>
              @yield('content')
          </div>
        </div>
      </div>
    </div>
    @include('_search')
	
	<!-- Yandex.Metrika counter --> 
	<script type="text/javascript" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, "script", "https://mc.yandex.ru/metrika/tag.js";, "ym") ym(15023650, "init", { id:15023650, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true }); </script> <noscript><div><img src="https://mc.yandex.ru/watch/15023650"; style="position:absolute; left:-9999px;" alt="" /></div></noscript> 
	<!-- /Yandex.Metrika counter -->
	
	<!-- Roistat counter --> 
	<script>(function(w, d, s, h, id) { w.roistatProjectId = id; w.roistatHost = h; var p = d.location.protocol == "https:" ? "https://"; : "http://";; var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init"; var js = d.createElement(s); js.charset="UTF-8"; js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);})(window, document, 'script', 'cloud.roistat.com', 'a539a58f5927729f3c365ee9a356fd35');</script>
	<!-- /Roistat counter -->
  </body>
</html>
