<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/favicon.png">

    <title>Paperwork</title>

    [[ HTML::style('css/bootstrap.min.css') ]]
    [[ HTML::style('css/bootstrap-theme.min.css') ]]
    [[ HTML::style('css/paperwork-login.min.css') ]]

  </head>
  <body>

    <div class="container">
      @yield("content")
    </div> <!-- /container -->

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    [[ HTML::script('js/html5shiv.min.js') ]]
    [[ HTML::script('js/respond.min.js') ]]
  <![endif]-->
  <!--[if lt IE 11]>
    [[ HTML::script('js/ie10-viewport-bug-workaround.js') ]]
  <![endif]-->
  </body>
</html>
