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

    [[ HTML::style('css/bootstrap-tagsinput.min.css') ]]

    [[ HTML::style('css/paperwork-login.min.css') ]]

  </head>
  <body>

    <div class="container">
      @yield("content")
    </div> <!-- /container -->


  [[ HTML::script('js/jquery.min.js') ]]
  [[ HTML::script('js/angular.min.js') ]]
  [[ HTML::script('js/angular-resource.min.js') ]]
  [[ HTML::script('js/angular-route.min.js') ]]

  <!-- [[ HTML::script('js/typeahead.min.js') ]] -->

  <!-- [[ HTML::script('js/bootstrap-tagsinput.min.js') ]] -->
  <!-- [[ HTML::script('js/bootstrap-tagsinput-angular.min.js') ]] -->

  [[ HTML::script('js/transition.min.js') ]]
  [[ HTML::script('js/collapse.min.js') ]]

  [[ HTML::script('js/bootstrap-tree.min.js') ]]

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  [[ HTML::script('js/ie10-viewport-bug-workaround.js') ]]
  </body>
</html>
