<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta name="theme-color" content="#03a9f4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#03a9f4">
    <!-- <link rel="apple-touch-startup-image" href=""> -->

    <link rel="icon" href="/images/paperwork-icons/favicon-64x64.png">
    <link rel="icon" sizes="128x128" href="/images/paperwork-icons/favicon-128x128.png">
    <link rel="icon" sizes="192x192" href="/images/paperwork-icons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/images/paperwork-icons/favicon-60x60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/images/paperwork-icons/favicon-76x76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/images/paperwork-icons/favicon-120x120.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/images/paperwork-icons/favicon-128x128.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/images/paperwork-icons/favicon-152x152.png">

    <title>Paperwork</title>

    <!-- [[ HTML::style('css/bootstrap.min.css') ]] -->
    <!-- [[ HTML::style('css/bootstrap-theme.min.css') ]] -->

    [[ HTML::style('css/themes/paperwork-v1.min.css') ]]

  </head>
  <body class="paperwork-guest">

    <div class="container">
      <div class="guest-logo">
        <img class="guest-logo-img" src="/images/paperwork-logo.png">
      </div>
      @yield("content")
    </div> <!-- /container -->

    <div class="footer [[ Config::get('paperwork.showIssueReportingLink') ? '' : 'hide' ]]">
      <div class="container">
        <div class="alert alert-warning" role="alert">
          <p>[[Lang::get('messages.found_bug')]]</p>
        </div>
      </div>
    </div>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    [[ HTML::script('js/ltie9compat.min.js') ]]
  <![endif]-->
  <!--[if lt IE 11]>
    [[ HTML::script('js/ltie11compat.js') ]]
  <![endif]-->
  [[ HTML::script('js/libraries.min.js') ]]
  </body>
</html>
