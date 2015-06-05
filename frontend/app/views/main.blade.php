@extends("layouts/user-layout")
@section("content")

@include('modal/messagebox')
@include('modal/notebook')
@include('modal/notebookSelect')
@include('modal/manageTags')
@include('modal/manageNotebooks')
@include('modal/usersSelect')
@include('modal/usersNotebookSelect')

<div class="container-fluid">
	<div class="row">
        <section pw-status-notification></section>
        <div class="fa sidebar-collapse-switch" ng-show="!expandedNoteLayout"
             ng-class="sidebarCollapsed ? 'fa-chevron-right sidebar-collapse-switch-closed' : 'fa-chevron-left col-sm-offset-3 col-md-offset-2'"
             ng-click="sidebarCollapsed = !sidebarCollapsed" ng-init="sidebarCollapsed = false"></div>
		<div id="sidebarNotebooks" class="col-sm-3 col-md-2 sidebar hidden-xs animate-panel disable-selection" ng-controller="SidebarNotebooksController" ng-show="isVisible()">
			<ul class="nav nav-sidebar sidebar-no-border" ng-hide="sidebarCollapsed">
				<div class="tree ">
					<ul class="tree-base">
						<li>
							<span class="tree-header tree-header-shortcuts"><i class="fa fa-chevron-down"></i> [[Lang::get('keywords.shortcuts')]]</span>
							<ul class="tree-child">
								<li class="tree-notebook" ng-repeat="shortcut in shortcuts | orderBy:'sortkey'" ng-cloak>
									<span ng-click="openNotebook(shortcut.id, shortcut.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }"><i class="fa fa-book"></i> {{shortcut.title}}</span>
								</li>
							</ul>
						</li>
						<li>
							<span class="tree-header tree-header-notebooks"><i class="fa fa-chevron-down"></i> [[Lang::get('keywords.notebooks')]] <button class="btn btn-default btn-xs pull-right" ng-click="modalManageNotebooks();$event.stopPropagation();" title="[[Lang::get('keywords.manage_notebooks')]]"><span class="fa fa-pencil"></span></button></span>
							<ul class="tree-child">
								<li class="tree-notebook" ng-repeat="notebook in notebooks | orderBy:'title'" ng-cloak>
									<div class="notebook-title" ng-click="openNotebook(notebook.id, notebook.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }" ng-drop="true" ng-drop-success="onDropSuccess($data,$event)"><i class="fa {{ notebookIconByType(notebook.type) }}"></i> {{notebook.title}}</div>
									<ul class="tree-child">
										<li class="tree-notebook" ng-repeat="child in notebook.children | orderBy:'title'">
											<div class="notebook-title" ng-click="openNotebook(child.id, child.type, child.id)" ng-class="{ 'active': child.id == getNotebookSelectedId() }"><i class="fa {{ notebookIconByType(child.type) }}"></i> {{child.title}}</div>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<span class="tree-header tree-header-tags"><i class="fa fa-chevron-down"></i> [[Lang::get('keywords.tags')]] <button class="btn btn-default btn-xs pull-right" ng-click="modalManageTags();$event.stopPropagation();" title="[[Lang::get('keywords.manage_tags')]]"><span class="fa fa-pencil"></span></button></span>
							<ul class="tree-child">
								<li class="tree-tag" ng-repeat="tag in tags | orderBy:'title':reverse" ng-cloak>
									<span ng-click="openTag(tag.id)" ng-class="{ 'active': tag.id == tagsSelectedId }" ng-drop="true" ng-drop-success="onDropToTag($data, $event)"><i class="fa fa-tag"></i> {{tag.title}}</span>
								</li>
							</ul>
						</li>
						<li>
							<span class="tree-header tree-header-calendar"><i class="fa fa-chevron-down"></i> Calendar</span>
							<ul class="tree-child">
								<li class="tree-calendar">
										<datepicker pw-datepicker-refresh="sidebarCalendarPromise" id="sidebarCalendar" date-disabled="sidebarCalendarIsDisabled(date, mode)" ng-change="openDate(sidebarCalendar)" ng-model="sidebarCalendar" show-weeks="false" ></datepicker>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</ul>
		</div>

		<div id="sidebarNotes" class="col-sm-4 col-md-3 sidebar hidden-xs animate-panel"
             ng-controller="SidebarNotesController" ng-show="isVisible()" ng-class="sidebarCollapsed ? '' : 'col-sm-offset-3 col-md-offset-2'">
			<ul id="notes-list" class="nav nav-sidebar notes-list sidebar-no-border" ng-controller="NotesListController">
				<li class="notes-list-item" ng-cloak ng-repeat="note in notes"
					ng-click="noteSelect(note.notebook_id, note.id)"
					ng-dblclick="editNote(note.notebook_id, note.id)"
					ng-class="{ 'active': (note.notebook_id + '-' + note.id == getNoteSelectedId() || (editMultipleNotes && notesSelectedIds[note.id])) }"
					ng-drag="true"
					ng-drag-success="onDragSuccess($data,$event)"
					ng-drag-data="notebook">
					<div class="notes-list-item-checkbox col-sm-1" ng-show="editMultipleNotes">
						<input name="notes[]" type="checkbox" value="{{ note.id }}" ng-model="notesSelectedIds[note.id]" ng-click="$event.stopPropagation();" ng-dblclick="$event.stopPropagation();">
					</div>
					<a class="{{ editMultipleNotes ? 'col-sm-11' : '' }}" href="#{{getNoteLink(note.notebook_id, note.id)}}">
						<div class="">
							<span class="notes-list-title notes-list-title-gradient">{{note.version.title || note.title}}</span>
							<span class="notes-list-date">
								<span class="notes-list-date-day">{{note.updated_at | convertdate | date : 'd'}}</span>
								<span class="notes-list-date-month">{{note.updated_at | convertdate | date : 'MMM'}}</span>
								<span class="notes-list-date-year">{{note.updated_at | convertdate | date : 'yyyy'}}</span>
							</span>
							<span class="notes-list-content notes-list-content-gradient" ng-bind-html="note.version.content_preview || note.content_preview"></span>
						</div>
					</a>
					<div class="clear"></div>
				</li>
			</ul>
		</div>

[[-- @if($welcomeNoteSaved == 1) --]
    [[-- HTML::script('js/special_note.js') --]]
[[-- @endif --]]
		<div id="paperworkViewParent" 
             class="main col-xs-12 {{ isVisible() ?
                (sidebarCollapsed ? 'col-sm-8 col-md-9 col-sm-offset-4 col-md-offset-3' : 'col-sm-5 col-md-7 col-sm-offset-7 col-md-offset-5' )
                : 'col-sm-12 col-md-12' }}"
             ng-controller="ViewController">
			<div id="paperworkView" ng-view></div>
		</div>
	</div>
</div>

@stop
