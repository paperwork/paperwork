<!DOCTYPE html>
<html lang="en">
  <head>
    @include('partials/header-sidewide-meta')

    <!-- [[ HTML::style('css/bootstrap.min.css') ]] -->
    <!-- [[ HTML::style('css/bootstrap-theme.min.css') ]] -->

    [[ HTML::style('css/themes/paperwork-v1.min.css') ]]

  </head>
  <body class="paperwork-guest">

    <div class="container">
      <div class="guest-logo">
        <img class="guest-logo-img" src="[[ asset('images/paperwork-logo.png') ]]">
      </div>
      @yield("content")
      <div class="footer [[ Config::get('paperwork.showIssueReportingLink') ? '' : 'hide' ]]">
        @include('partials/error-reporting-footer')
      </div>
    </div> <!-- /container -->

  [[ HTML::script('js/jquery.min.js') ]]

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
