<ul class="nav navbar-nav animate-panel" ng-cloak ng-show="navbarMainMenu">
	<li class="dropdown">
		<a id="menu-item-file" href="" class="dropdown-toggle transition-effect" data-toggle="dropdown">[[Lang::get('keywords.file')]] <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li ng-controller="SidebarNotesController" class="{{ menuItemNotebookClass() }}">
				<a id="menu-item-file-sub-new_note" href="" ng-click="newNote(getNotebookSelectedId())"><i class="fa fa-file"></i> [[Lang::get('keywords.new_note')]]</a>
			</li>
			<li ng-controller="SidebarNotebooksController">
				<a id="menu-item-file-sub-new_notebook" href="" ng-click="modalNewNotebook()"><i class="fa fa-book"></i> [[Lang::get('keywords.new_notebook')]]</a>
			</li>
			<li>
				<a id="menu-item-file-sub-new_collection" href="" data-toggle="modal" data-target="#modalCollection"><i class="fa fa-folder"></i> [[Lang::get('keywords.new_collection')]]</a>
			</li>
		</ul>
	</li>
	<li class="dropdown">
		<a id="menu-item-edit" href="" class="dropdown-toggle transition-effect" data-toggle="dropdown">[[Lang::get('keywords.edit')]] <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('single') }}">
				<a id="menu-item-edit-sub-edit_note" href="" ng-click="editNote(getNotebookSelectedId(), (getNoteSelectedId(true).noteId))"><i class="fa fa-pencil"></i> [[Lang::get('keywords.edit_note')]]</a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a id="menu-item-edit-sub-edit_notes" href="" ng-click="editNotes(getNotebookSelectedId())"><i class="fa fa-files-o"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.edit_notes')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.edit_notes_cancel')]]</span></a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a id="menu-item-edit-sub-move_note" href="" ng-click="modalMoveNote(getNotebookSelectedId(), (getNoteSelectedId(true)).noteId)"><i class="fa fa-arrow-right"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.move_note')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.move_notes')]]</span></a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a id="menu-item-edit-sub-delete_note" href="" ng-click="modalDeleteNote(getNotebookSelectedId(), (getNoteSelectedId(true)).noteId)"><i class="fa fa-trash-o"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.delete_note')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.delete_notes')]]</span></a>
			</li>
			<li ng-controller="SidebarNotesController" class="{{ menuItemNoteClass('multiple') }}">
				<a id="menu-item-edit-sub-share_note" href="" ng-click="modalShareNote(getNotebookSelectedId(), (getNoteSelectedId(true)).noteId)"><i class="fa fa-share-alt"></i> <span ng-hide="editMultipleNotes">[[Lang::get('keywords.share_note')]]</span><span ng-show="editMultipleNotes">[[Lang::get('keywords.share_notes')]]</span></a>
			</li>
			<li class="divider"></li>
			<li ng-controller="SidebarNotebooksController" class="{{ menuItemNotebookClass() }}">
				<a id="menu-item-edit-sub-edit_notebook" href="" ng-click="modalEditNotebook(getNotebookSelectedId())"><i class="fa fa-pencil"></i> [[Lang::get('keywords.edit_notebook')]]</a>
			</li>
			<li ng-controller="SidebarNotebooksController" class="{{ menuItemNotebookClass() }}">
				<a id="menu-item-edit-sub-share_notebook" href="" ng-click="modalShareNotebook(getNotebookSelectedId())"><i class="fa fa-share-alt"></i> [[Lang::get('keywords.share_notebook')]]</a>
			</li>
			<li ng-controller="SidebarNotebooksController" class="{{ menuItemNotebookClass() }}">
				<a id="menu-item-edit-sub-delete_notebook" href="" ng-click="modalDeleteNotebook(getNotebookSelectedId())"><i class="fa fa-trash-o"></i> [[Lang::get('keywords.delete_notebook')]]</a>
			</li>
		</ul>
	</li>
</ul>
