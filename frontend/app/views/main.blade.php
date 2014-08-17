@extends("layouts/user-layout")
@section("content")

@include('modal/messagebox')
@include('modal/notebook')

<div class="container-fluid">
	<div class="row">
		<div id="sidebarNotebooks" class="col-sm-3 col-md-2 sidebar hidden-xs animate-panel disable-selection" ng-controller="paperworkSidebarNotebooksController" ng-show="isVisible()">
			<ul class="nav nav-sidebar sidebar-no-border">
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

		<div id="sidebarNotes" class="col-sm-4 col-sm-offset-3 col-md-3 col-md-offset-2 sidebar hidden-xs animate-panel" ng-controller="paperworkSidebarNotesController" ng-show="isVisible()">
			<ul id="notes-list" class="nav nav-sidebar notes-list sidebar-no-border" ng-controller="paperworkNotesListController">
				<li class="notes-list-item" ng-repeat="note in notes" ng-click="noteSelect(note.notebook_id, note.id)" ng-dblclick="editNote(note.notebook_id, note.id)" ng-class="{ 'active': note.notebook_id + '-' + note.id == getNoteSelectedId() }">
					<a href="#{{getNoteLink(note.notebook_id, note.id)}}">
						<span class="notes-list-title notes-list-title-gradient">{{note.title}}</span>
						<span class="notes-list-date">
							<span class="notes-list-date-day">{{note.updated_at | convertdate | date : 'd'}}</span>
							<span class="notes-list-date-month">{{note.updated_at | convertdate | date : 'MMM'}}</span>
							<span class="notes-list-date-year">{{note.updated_at | convertdate | date : 'yyyy'}}</span>
						</span>
						<span class="notes-list-content notes-list-content-gradient">{{note.content}}</span>
					</a>
				</li>
			</ul>
		</div>

		<div id="paperworkViewParent" class="{{ isVisible() ? 'col-xs-12 col-sm-5 col-sm-offset-7 col-md-7 col-md-offset-5 main' : 'col-xs-12 col-sm-12 col-md-12 main' }}" ng-controller="paperworkViewController">
			<div id="paperworkView" ng-view></div>
		</div>
	</div>
</div>

@stop