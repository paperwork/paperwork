@extends("layouts/user-layout")
@section("content")

@include('modal/new-notebook')

<div class="container-fluid">
	<div class="row">
		<div id="sidebarNotebooks" class="col-sm-3 col-md-2 sidebar" ng-controller="paperworkSidebarNotebooksController" ng-show="isVisible()">
			<a class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#modalNewNotebook">[[Lang::get('keywords.new_notebook')]]</a>
			<a class="btn btn-primary btn-sm btn-block" ng-disabled="notebooks.length">[[Lang::get('keywords.new_note')]]</a>
			<ul class="nav nav-sidebar">
				<div class="tree ">
					<ul class="tree-base">
						<li>
							<span class="tree-header"><i class="fa fa-chevron-circle-down"></i> [[Lang::get('keywords.shortcuts')]]</span>
							<ul class="tree-child">
								<li class="tree-notebook" ng-repeat="shortcut in shortcuts | orderBy:'sortkey'">
									<span ng-click="openNotebook(shortcut.id, shortcut.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }"><i class="fa fa-book"></i> {{shortcut.title}}</span>
								</li>
							</ul>
						</li>
						<li>
							<span class="tree-header"><i class="fa fa-chevron-circle-down"></i> [[Lang::get('keywords.notebooks')]]</span>
							<ul class="tree-child">
								<li class="tree-notebook" ng-repeat="notebook in notebooks | orderBy:'title'">
									<span ng-click="openNotebook(notebook.id, notebook.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }"><i class="fa {{ notebookIconByType(notebook.type) }}"></i> {{notebook.title}}</span>
									<ul class="tree-child">
										<li class="tree-notebook" ng-repeat="child in notebook.children | orderBy:'title'">
											<span ng-click="openNotebook(child.id, child.type, child.id)" ng-class="{ 'active': child.id == getNotebookSelectedId() }"><i class="fa {{ notebookIconByType(child.type) }}"></i> {{child.title}}</span>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<span class="tree-header"><i class="fa fa-chevron-circle-down"></i> [[Lang::get('keywords.tags')]]</span>
							<ul class="tree-child">
								<li class="tree-tag" ng-repeat="tag in tags">
									<span ng-click="openTag(tag.id)" ng-class="{ 'active': tag.id == tagsSelectedId }"><i class="fa fa-tag"></i> {{tag.title}}</span>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</ul>
		</div>

		<div "sidebarNotes" class="col-sm-4 col-sm-offset-3 col-md-3 col-md-offset-2 sidebar" ng-controller="paperworkSidebarNotesController" ng-show="isVisible()">
			<div id="search-form">
				<form id="searchForm" role="form" ng-submit="submitSearch()">
					<input type="text" class="form-control" placeholder="[[Lang::get('keywords.search_dotdotdot')]]" ng-model="search">
				</form>
			</div>

			<ul id="notes-list" class="nav nav-sidebar notes-list" ng-controller="paperworkNotesListController">
				<li class="notes-list-item" ng-repeat="note in notes" ng-click="noteSelect(note.notebook_id, note.id)" ng-class="{ 'active': note.notebook_id + '-' + note.id == getNoteSelectedId() }">
					<a href="#{{getNoteLink(note.notebook_id, note.id)}}">
						<span class="notes-list-title">{{note.title}} <span class="label label-primary">{{note.updated_at | convertdate | date : 'shortDate'}}</span></span>
						<span class="notes-list-content">{{note.content_preview}}</span>
					</a>
				</li>
			</ul>
		</div>

		<div class="{{ isVisible() ? 'col-sm-5 col-sm-offset-7 col-md-7 col-md-offset-5 main' : 'col-sm-12 col-md-12 main' }}" ng-controller="paperworkViewController">
			<div ng-view></div>
		</div>
	</div>
</div>

@stop