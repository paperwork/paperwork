@extends("layouts/user-layout")
@section("content")

@include('modal/messagebox')
@include('modal/notebook')
@include('modal/notebookSelect')
@include('modal/manageTags')
@include('modal/manageNotebooks')
@include('modal/usersSelect')
@include('modal/usersNotebookSelect')
@include('modal/collection')
@include('modal/notebookDelete')

<div class="container-fluid">
	<div class="row">
        <section pw-status-notification></section>
        <div class="col-md-5 col-sm-7 hidden-xs">
            <div class="fa sidebar-collapse-switch" ng-show="!expandedNoteLayout"
                ng-class="sidebarCollapsed ? 'fa-chevron-right sidebar-collapse-switch-closed' : 'fa-chevron-left col-sm-offset-3 col-md-offset-2'"
                ng-click="sidebarCollapsed = !sidebarCollapsed" ng-init="sidebarCollapsed = false"></div>
    		<div id="sidebarNotebooks" class="col-sm-3 col-md-2 sidebar hidden-xs animate-panel disable-selection" ng-controller="SidebarNotebooksController" ng-show="isVisible()" ng-hide="sidebarCollapsed" ng-init="initialiseSidebar()">
    			<ul class="nav nav-sidebar sidebar-no-border" ng-hide="sidebarCollapsed">
    				<div class="tree">
    					<ul class="tree-base">
    						<li>
    							<span class="tree-header tree-header-shortcuts" title="Click to {{ shortcutsCollapsed ? 'Expand' : 'Collapse' }}" ng-click="shortcutsCollapsed=!shortcutsCollapsed"><i class="fa {{ shortcutsCollapsed ? 'fa-chevron-right' : 'fa-chevron-down' }}"></i> [[Lang::get('keywords.shortcuts')]]</span>
    							<ul class="tree-child" collapse="shortcutsCollapsed">
    								<li class="tree-notebook" ng-repeat="shortcut in shortcuts | orderBy:'sortkey'" ng-cloak>
    									<span ng-click="openNotebook(shortcut.id, shortcut.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }"><i class="fa fa-book"></i> {{shortcut.title}}</span>
    								</li>
    							</ul>
    						</li>
    						<li>
    							<span class="tree-header tree-header-notebooks" title="Click to {{ notebooksCollapsed ? 'Expand' : 'Collapse' }}" ng-click="notebooksCollapsed=!notebooksCollapsed"><i class="fa {{ notebooksCollapsed ? 'fa-chevron-right' : 'fa-chevron-down' }}"></i> [[Lang::get('keywords.notebooks')]] <button class="btn btn-default btn-xs pull-right" ng-click="modalManageNotebooks();$event.stopPropagation();" title="[[Lang::get('keywords.manage_notebooks')]]"><span class="fa fa-pencil"></span></button></span>
    							<ul class="tree-child" collapse="notebooksCollapsed">
    								<li class="tree-notebook" ng-repeat="notebook in notebooks | orderBy:'title'" ng-cloak>
    									<div class="notebook-title" ng-click="openNotebook(notebook.id, notebook.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }" ng-drop="true" ng-drop-success="onDropSuccess($data,$event)"><i class="fa" ng-class="isCollectionOpen(notebook.id) ? 'fa-folder-open' : notebookIconByType(notebook.type)"></i> {{notebook.title}}</div>
    									<ul class="tree-child tree-children" ng-class=" { 'hidden': !isCollectionOpen(notebook.id) } ">
    										<li class="tree-notebook" ng-repeat="child in notebook.children | orderBy:'title'">
    											<div class="notebook-title" ng-click="openNotebook(child.id, child.type, child.id)" ng-class="{ 'active': child.id == getNotebookSelectedId() }"><i class="fa {{ notebookIconByType(child.type) }}"></i> {{child.title}}</div>
    										</li>
    									</ul>
    								</li>
    							</ul>
    						</li>
    						<li>
    							<span class="tree-header tree-header-tags" title="Click to {{ tagsCollapsed ? 'Expand' : 'Collapse' }}" ng-click="tagsCollapsed=!tagsCollapsed"><i class="fa {{ tagsCollapsed ? 'fa-chevron-right' : 'fa-chevron-down' }}"></i> [[Lang::get('keywords.tags')]] <button class="btn btn-default btn-xs pull-right" ng-click="modalManageTags();$event.stopPropagation();" title="[[Lang::get('keywords.manage_tags')]]"><span class="fa fa-pencil"></span></button></span>
    							<ul class="tree-child" collapse="tagsCollapsed">
    								<li class="tree-tag" ng-repeat="tag in tags | orderBy:'title':reverse" >
    									<span class="tree-child tag-parent" ng-click="tag.collapsed=!tag.collapsed"><i class="fa {{ tag.collapsed ? 'fa-chevron-right' : 'fa-chevron-down' }}" ng-show="(tag.children.length > 0)"></i></span><div class="tree-child" ng-click="openTag(tag.id)" ng-class="{ 'active': tag.id == tagsSelectedId }" ng-drop="true" ng-drop-success="onDropToTag($data, $event)" ng-drag="(tag.children.length == 0)" ng-drag-success="onDragSuccess($data, $event)" ng-drag-data="tag"><i class="fa fa-tag" ng-show="(tag.children.length == 0)"></i> {{tag.title}}</div>
    									<ul class="tree-child" collapse="tag.collapsed">
    										<li class="tree-tag" ng-repeat="child in tag.children | orderBy:'title'" >
    											<span ng-click="openTag(child.id)" ng-class="{ 'active': child.id == tagsSelectedId }" ng-drop="true" ng-drop-success="onDropToTag($data, $event)" ng-drag="true" ng-drag-success="onDragSuccess($data, $event)" ng-drag-data="child"><i class="fa fa-tag"></i> {{child.title}}</span>
    										</li>
    									</ul>
    								</li>
    							</ul>
    						</li>
    						<li>
    							<span class="tree-header tree-header-calendar" title="Click to {{ calendarCollapsed ? 'Expand' : 'Collapse' }}" ng-click="calendarCollapsed=!calendarCollapsed"><i class="fa {{ calendarCollapsed ? 'fa-chevron-right' : 'fa-chevron-down' }}"></i> Calendar</span>
    							<ul class="tree-child" collapse="calendarCollapsed">
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
                 ng-controller="SidebarNotesController" ng-show="isVisible()" ng-class="sidebarCollapsed ? 'sidebar-collapsed-notes' : 'col-sm-offset-3 col-md-offset-2'" ng-if="(notes.length != 0)">
    			<div class="nav nav-sidebar notes-list sidebar-no-border" ng-class="sidebarCollapsed ? 'sidebar-collapsed-notes-list' : ''" ng-cloak>
    			    <p class="text-center">
    			        [[ Lang::get('keywords.sort_notes_by') ]]
    			        <select id="sort_order_change" ng-change="changeSortOrder(sort_order_adjustment)" ng-model="sort_order_adjustment">
    			            <option value="default">[[ Lang::get('keywords.default') ]]</option>
    			            <option value="creation_date">[[ Lang::get('keywords.creation_date') ]]</option>
    			            <option value="modification_date">[[ Lang::get('keywords.modification_date') ]]</option>
    			            <option value="title">[[ Lang::get('keywords.title') ]]</option>
    			        </select>
    			    </p>
    			    <p class="text-center new-note-notes-list-button">
    			        <a ng-controller="SidebarNotesController" ng-click="newNote(getNotebookSelectedId())" href><i class="fa fa-plus"></i> [[ Lang::get('keywords.new_note') ]]</a>
    			    </p>
    			</div>
    			<ul id="notes-list" class="nav nav-sidebar notes-list sidebar-no-border" ng-controller="NotesListController" ng-class="sidebarCollapsed ? 'sidebar-collapsed-notes-list' : ''">
    				<li class="notes-list-item" ng-cloak ng-repeat="note in notes"
    					ng-click="noteSelect(note.notebook_id, note.id)"
    					ng-dblclick="editNote(note.notebook_id, note.id)"
    					ng-class="{ 'active': (note.notebook_id + '-' + note.id == getNoteSelectedId() || (editMultipleNotes && notesSelectedIds[note.id])) }"
    					ng-drag="true"
    					ng-drag-data="(note)"
    					ng-drag-success="onDragSuccess($data,$event)"
    					ng-drag-data="notebook"
    					data-allow-transform="false">
    					<span class="draggable"></span>
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
		</div>

[[-- @if($welcomeNoteSaved == 1) --]
    [[-- HTML::script('js/special_note.js') --]]
[[-- @endif --]]
		<div id="paperworkViewParent" 
             class="main col-xs-12 {{ isVisible() ?
                (sidebarCollapsed ? 'col-sm-8 col-md-9 col-sm-offset-4 col-md-offset-3' : 'col-sm-5 col-md-7 col-sm-offset-7 col-md-offset-5' )
                : 'col-sm-12 col-md-12' }}"
             ng-controller="ViewController">
             <div class="text-center" 
                  id="paperworkViewEmpty" 
                  ng-if="(notes.length == 0)" 
                  ng-show="!expandedNoteLayout" 
                  ng-class="" 
                  ng-init=""
                  ng-cloak>
		        <p style="font-size:15px;padding-top:15px;display:none">[[ Lang::get('messages.no_notes_in_notebook') ]]</p>
		        <h1>[[ Lang::get('messages.nothing_here') ]]</h1>
		        <p style="font-size:15px;padding-top:15px">[[ Lang::get('messages.no_notes_in_notebook') ]]</p>
             </div>
			<div id="paperworkView" ng-view></div>
		</div>
	</div>
</div>

@stop
