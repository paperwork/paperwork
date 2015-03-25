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
        <img class="guest-logo-img" src="/images/paperwork-logo.png">
      </div>
      @yield("content")
    </div> <!-- /container -->

    <div class="footer [[ Config::get('paperwork.showIssueReportingLink') ? '' : 'hide' ]]">
      <div class="container">
        <?php
            $branch = exec("git symbolic-ref --short HEAD");
            $ch = curl_init();
        	curl_setopt($ch,CURLOPT_URL,"https://api.github.com/repos/twostairs/paperwork/git/refs/heads/$branch");
        	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
        	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,1);
        	curl_setopt($ch,CURLOPT_USERAGENT,"Colorado");
        	$content = curl_exec($ch);

        	$jsonFromApi = array();
        	$jsonFromApi[] = json_decode($content);
        	$jsonResult = $jsonFromApi[0];
        	if(isset($jsonFromApi[0]->object->sha)) {
        	    $commitSha = str_replace('"', '', $jsonFromApi[0]->object->sha);
        	}else{
        	    $commitSha = "";
        	}
        	$lastCommitOnInstall = exec("git log | head -n 1 | awk '{ print $2 }'");
        ?>
        @if($lastCommitOnInstall === $commitSha)
        <div class="alert alert-warning" role="alert">
          <p>[[Lang::get('messages.found_bug')]]</p>
        </div>
        @else
        <div class="alert alert-danger" role="alert">
            <p>[[Lang::get('messages.new_version_available')]]
        </div>
        @endif
      </div>
    </div>

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
