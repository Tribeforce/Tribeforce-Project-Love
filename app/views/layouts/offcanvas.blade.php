<!DOCTYPE html>

<?php $lang = Config::get('app.locale'); ?>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="{{ $lang }}"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="{{ Config::get('app.locale')}}"> <!--<![endif]-->
  <head>
    <meta charset="utf-8" />

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, user-scalable=0" />

    <title>Tribeforce - {{ $title }}</title>

    <!-- Included CSS Files -->
    {{HTML::style('/css/fontello/fontello.css')}}
    {{HTML::style('/css/fontello/animation.css')}}
    {{HTML::style('/css/offcanvas.css')}}
    {{HTML::style('/css/pickdate/default.css')}}
    {{HTML::style('/css/pickdate/default.date.css')}}
    {{HTML::style('https://fonts.googleapis.com/css?family=Titillium+Web:400,200,700')}}
    {{HTML::style('/css/app.css')}}



    <link rel="apple-touch-icon" HREF="/images/apple-touch-icon.png">

    {{HTML::script('/js/vendor/custom.modernizr.js')}}

    </head>
    <body class="{{ page_name() }} off-canvas slide-nav">
      <header id="header" class="row">
        @include('header')
      </header>
      <div class="row">
        <section role="main">
          @include('messages')
          <h1>{{ $title }}</h1>
          @yield('main')
        </section>
        <section id="sidebar" role="complementary">
          @yield('sidebar')
        </section>
      </div>
      <footer class="site-footer row" role="contentinfo">
        <div class="small-12 columns">
          <small>Last updated: {{lastUpdated()}}</small>
        </div>
      </footer>
    </div>

    <?php //TODO: update zepto or jquery to the latest versions ?>
    <script>
//    document.write('<script src=' +
//    ('__proto__' in {} ? '/js/vendor/zepto' : '/js/vendor/jquery') +
//    '.js><\/script>')
    </script>
    {{HTML::script('/js/jquery-2.0.0.min.js')}}

    <?php //TODO: Find and include the foundation.min.js ?>
    {{HTML::script('/js/foundation/foundation.js')}}
    {{HTML::script('/js/foundation/foundation.section.js')}}
    {{HTML::script('/js/foundation/foundation.joyride.js')}}
    {{HTML::script('/js/foundation/foundation.clearing.js')}}
    {{HTML::script('/js/foundation/foundation.magellan.js')}}
    {{HTML::script('/js/foundation/foundation.tooltips.js')}}
    {{HTML::script('/js/foundation/foundation.topbar.js')}}
    {{HTML::script('/js/foundation/foundation.alerts.js')}}
    {{HTML::script('/js/foundation/foundation.forms.js')}}
    {{HTML::script('/js/foundation/foundation.orbit.js')}}
    {{HTML::script('/js/foundation/foundation.reveal.js')}}
    {{HTML::script('/js/foundation/foundation.placeholder.js')}}
    {{HTML::script('/js/foundation/foundation.dropdown.js')}}
    {{HTML::script('/js/foundation/foundation.cookie.js')}}
    {{HTML::script('/js/foundation/foundation.offcanvas.js')}}

    {{HTML::script('/js/pickdate/picker.js')}}
    {{HTML::script('/js/pickdate/picker.date.js')}}
    @if($lang === 'nl')
      {{HTML::script('/js/pickdate/translations/nl_NL.js')}}
    @endif
    {{HTML::script('/js/script.js')}}
    <script>
      $(document).foundation('alerts topbar section tooltips dropdown reveal',
                             { deep_linking: true,
                               one_up: false,
                               callback: accordeonSlide,
                               small_breakpoint: 520},
                             function(response) {
        console.log(response.errors);
      });
    </script>

    {{HTML::script('/jquery-ui/ui/jquery.ui.core.js')}}
    {{HTML::script('/jquery-ui/ui/jquery.ui.widget.js')}}
    {{HTML::script('/jquery-ui/ui/jquery.ui.mouse.js')}}
    {{HTML::script('/jquery-ui/ui/jquery.ui.draggable.js')}}
    {{HTML::script('/jquery-ui/ui/jquery.ui.droppable.js')}}
    {{HTML::script('/jquery-ui/ui/jquery.ui.touch-punch.min.js')}}
  </body>
</html>
