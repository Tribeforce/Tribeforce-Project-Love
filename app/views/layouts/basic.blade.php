<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="{{ Config::get('app.locale')}}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ Config::get('app.locale')}}"> <!--<![endif]-->
  <head>
    <meta charset="UTF-8">
    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=0" />

    <title>{{ $title }}</title>
    {{HTML::style('/css/fontello/fontello.css')}}
    {{HTML::style('https://fonts.googleapis.com/css?family=Titillium+Web:400,200,700')}}
    {{HTML::style('/css/app.css')}}
    <link rel="apple-touch-icon" HREF="/images/apple-touch-icon.png">
    <style>
    body {
      padding-top: 10px;
    }
    </style>
  </head>
  <body class="{{ page_name() }}">
    <div class="row header">
      <div class="columns small-10 small-centered large-6 large-centered">
        <a href="/">{{ HTML::image('images/logo.png', 'Tribeforce logo') }}</a>
        @include('messages')

        @yield('body')
      </div>
    </div>

    <?php //TODO: update zepto or jquery to the latest versions ?>
    <script>
    document.write('<script src=' +
    ('__proto__' in {} ? '/js/vendor/zepto' : '/js/vendor/jquery') +
    '.js><\/script>')
    </script>

    <?php //TODO: Find and include the foundation.min.js ?>
    <script src="/js/foundation/foundation.js"></script>
    <script src="/js/foundation/foundation.forms.js"></script>
    <script src="/js/foundation/foundation.alerts.js"></script>

    <script>
      $('body').css('minHeight', $(window).height() - 10);
      $(document).foundation();
    </script>
  </body>
</html>
