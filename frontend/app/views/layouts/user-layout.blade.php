<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Paperwork</title>

	[[ HTML::style('css/bootstrap.min.css') ]]
    [[ HTML::style('css/bootstrap-theme.min.css') ]]

    [[ HTML::style('css/bootstrap-tagsinput.min.css') ]]

    [[ HTML::style('css/freqselector.min.css') ]]

    [[ HTML::style('css/paperwork.min.css') ]]


</head>
  <body ng-app="paperworkNotes">

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">[[Lang::get('keywords.toggle_navigation')]]</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand transition-effect" href="#">Paperworks</a>
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

				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">[[Lang::get('keywords.file')]] <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li ng-controller="paperworkSidebarNotesController"><a href="" class="{{notebooks.length ? '' : 'disabled'}}"><i class="fa fa-file"></i> [[Lang::get('keywords.new_note')]]</a></li>
							<li ng-controller="paperworkSidebarNotebooksController"><a href="" ng-click="modalNewNotebook()"><i class="fa fa-book"></i> [[Lang::get('keywords.new_notebook')]]</a></li>
							<li><a href="" data-toggle="modal" data-target="#modalCollection"><i class="fa fa-folder"></i> [[Lang::get('keywords.new_collection')]]</a></li>
							<li class="divider"></li>
							<li><a href=""><i class="fa fa-upload"></i> [[Lang::get('keywords.upload_document')]]</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown">[[Lang::get('keywords.edit')]] <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li ng-controller="paperworkSidebarNotebooksController" class="{{getNotebookSelectedId() == 0 ? 'disabled' : ''}}"><a href="" ng-click="modalEditNotebook(getNotebookSelectedId())"><i class="fa fa-pencil"></i> [[Lang::get('keywords.edit_notebook')]]</a></li>
							<li ng-controller="paperworkSidebarNotebooksController" class="{{getNotebookSelectedId() == 0 ? 'disabled' : ''}}"><a href="" ><i class="fa fa-trash-o"></i> [[Lang::get('keywords.delete_notebook')]]</a></li>
							<li class="divider"></li>
							<li><a href=""><i class="fa fa-files-o"></i> [[Lang::get('keywords.edit_notes')]]</a></li>
						</ul>
					</li>
				</ul>
				<form ng-controller="paperworkSidebarNotesController" class="navbar-form navbar-left" id="searchForm" role="form" ng-submit="submitSearch()">
					<div class="form-group">
						<input type="text" class="form-control navbar-search" placeholder="[[Lang::get('keywords.search_dotdotdot')]]" ng-model="search">
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="[[ URL::route("/") ]]" class="transition-effect"><i class="fa fa-book"></i> [[Lang::get('keywords.library')]]</a></li>
					<li><a href="[[ URL::route("user/profile") ]]" class="transition-effect"><i class="fa fa-user"></i> [[Lang::get('keywords.profile')]]</a></li>
					<li><a href="[[ URL::route("user/settings") ]]" class="transition-effect"><i class="fa fa-cog"></i> [[Lang::get('keywords.settings')]]</a></li>
					<li><a href="[[ URL::route("user/help") ]]" class="transition-effect"><i class="fa fa-question"></i> [[Lang::get('keywords.help')]]</a></li>
					<li><a href="[[ URL::route("user/logout") ]]" class="transition-effect"><i class="fa fa-sign-out"></i> [[Lang::get('keywords.sign_out')]]</a></li>
				</ul>
			</div>
		</div>
	</div>

	@yield("content")

	[[ HTML::script('js/jquery.min.js') ]]
	[[ HTML::script('js/jquery.overscroll.min.js') ]]
	[[ HTML::script('js/jquery.scrollTo.min.js') ]]

	[[ HTML::script('js/freqselector.min.js') ]]

	[[ HTML::script('js/angular.min.js') ]]
	[[ HTML::script('js/angular-resource.min.js') ]]
	[[ HTML::script('js/angular-route.min.js') ]]

	<!-- [[ HTML::script('js/typeahead.min.js') ]] -->

	<!-- [[ HTML::script('js/bootstrap-tagsinput.min.js') ]] -->
	<!-- [[ HTML::script('js/bootstrap-tagsinput-angular.min.js') ]] -->

	[[ HTML::script('js/paperwork-note.min.js') ]]

	[[ HTML::script('js/transition.min.js') ]]
	[[ HTML::script('js/collapse.min.js') ]]

	[[ HTML::script('js/bootstrap-tree.min.js') ]]
	[[ HTML::script('js/bootstrap-dropdown.min.js') ]]
	[[ HTML::script('js/bootstrap-modal.min.js') ]]

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	[[ HTML::script('js/ie10-viewport-bug-workaround.js') ]]

</body>
</html>
