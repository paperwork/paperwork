<ul class="nav navbar-nav animate-panel" ng-cloak ng-show="navbarMainMenu">
	<li class="dropdown">
		<a href="" class="dropdown-toggle transition-effect" data-toggle="dropdown">[[Lang::get('keywords.file')]] <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li ng-controller="SidebarNotesController" class="{{ menuItemNotebookClass() }}">
				<a href="" ng-click="newNote(getNotebookSelectedId())"><i class="fa fa-file"></i> [[Lang::get('keywords.new_note')]]</a>
			</li>
			<li ng-controller="SidebarNotebooksController">
				<a href="" ng-click="modalNewNotebook()"><i class="fa fa-book"></i> [[Lang::get('keywords.new_notebook')]]</a>
			</li>
			<li>
				<a href="" data-toggle="modal" data-target="#modalCollection"><i class="fa fa-folder"></i> [[Lang::get('keywords.new_collection')]]</a>
			</li>
		</ul>
	</li>
	<li class="dropdown">
		<a href="" class="dropdown-toggle transition-effect" data-toggle="dropdown">[[Lang::get('keywords.edit')]] <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('single') }}">
				<a href="" ng-click="editNote(getNotebookSelectedId(), (getNoteSelectedId(true).noteId))"><i class="fa fa-pencil"></i> [[Lang::get('keywords.edit_note')]]</a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a href="" ng-click="editNotes(getNotebookSelectedId())"><i class="fa fa-files-o"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.edit_notes')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.edit_notes_cancel')]]</span></a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a href="" ng-click="modalMoveNote(getNotebookSelectedId(), (getNoteSelectedId(true)).noteId)"><i class="fa fa-arrow-right"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.move_note')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.move_notes')]]</span></a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a href="" ng-click="modalDeleteNote(getNotebookSelectedId(), (getNoteSelectedId(true)).noteId)"><i class="fa fa-trash-o"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.delete_note')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.delete_notes')]]</span></a>
			</li>
			<li class="divider"></li>
			<li ng-controller="SidebarNotebooksController" class="{{ menuItemNotebookClass() }}">
				<a href="" ng-click="modalEditNotebook(getNotebookSelectedId())"><i class="fa fa-pencil"></i> [[Lang::get('keywords.edit_notebook')]]</a>
			</li>
			<li ng-controller="SidebarNotebooksController" class="{{ menuItemNotebookClass() }}">
				<a href="" ng-click="modalDeleteNotebook(getNotebookSelectedId())"><i class="fa fa-trash-o"></i> [[Lang::get('keywords.delete_notebook')]]</a>
			</li>
		</ul>
	</li>
</ul>
