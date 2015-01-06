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

    [[ HTML::style('css/freqselector.min.css') ]]

    [[ HTML::style('css/typeahead.min.css') ]]

</head>
  <body ng-app="paperworkNotes">
  	<div ng-controller="paperworkConstructorController"></div>

	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">[[Lang::get('keywords.toggle_navigation')]]</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="paperwork-logo navbar-brand transition-effect" href="[[ URL::route("/") ]]"><img src="/images/navbar-logo.png"> Paperwork</a>
			</div>
			<div class="navbar-collapse collapse">
				<div class="visible-xs">
					<form class="navbar-form" role="form">
				  		<div class="form-group" ng-controller="paperworkSidebarNotebooksController">
				  			<select class="form-control navbar-search">
							  <option ng-repeat="notebook in notebooks" data-notebookid="{{ notebook.children.length > 0 ? '' : notebook.id }}">{{notebook.title}}</option>
							</select>
						</div>
				  		<div class="form-group" ng-controller="paperworkSidebarNotesController">
				  			<select class="form-control navbar-search">
							  <option ng-repeat="note in notes">{{note.title}}</option>
							</select>
						</div>
					</form>
				</div>

				@include('partials/menu-main')

				@include('partials/search-main')

				@include('partials/navigation-main')
			</div>
		</div>
	</div>

	@yield("content")

    <div class="footer footer-issue [[ Config::get('paperwork.showIssueReportingLink') ? '' : 'hide' ]]">
      <div class="">
        <div class="alert alert-warning" role="alert">
          <p>[[Lang::get('messages.found_bug')]]</p>
        </div>
      </div>
    </div>

	[[ HTML::script('js/jquery.min.js') ]]
	[[ HTML::script('js/libraries.min.js') ]]
	[[ HTML::script('js/angular.min.js') ]]

	[[ HTML::script('js/paperwork.min.js') ]]

	[[ HTML::script('js/bootstrap.min.js') ]]
	[[ HTML::script('js/tagsinput.min.js') ]]

	[[ HTML::script('ckeditor/ckeditor.js') ]]

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
    [[ HTML::script('js/ltie9compat.min.js') ]]
  <![endif]-->
  <!--[if lt IE 11]>
    [[ HTML::script('js/ltie11compat.js') ]]
  <![endif]-->

</body>
</html>
