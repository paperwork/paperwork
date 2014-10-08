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
    [[ HTML::style('css/freqselector.min.css') ]]
    [[ HTML::style('css/paperwork.min.css') ]]

    [[ HTML::style('css/bootstrap-tagsinput.min.css') ]]
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
	[[ HTML::script('js/freqselector.min.js') ]]
	[[ HTML::script('js/retina.min.js') ]]
	[[ HTML::script('js/angular.min.js') ]]

	[[ HTML::script('js/paperwork.min.js') ]]

	[[ HTML::script('js/bootstrap.min.js') ]]
	[[ HTML::script('js/bootstrap-tree.min.js') ]]
	[[ HTML::script('js/typeahead.min.js') ]]
	[[ HTML::script('js/bootstrap-tagsinput.min.js') ]]

	[[ HTML::script('ckeditor/ckeditor.js') ]]

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
