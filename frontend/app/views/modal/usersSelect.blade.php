<div ng-controller="SidebarNotesController" class="modal fade" id="modalUsersSelect" tabindex="-1" role="dialog" aria-labelledby="modalUsersSelectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      [[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
      <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" id="modalUsersSelectLabel">
	  [[Lang::get('keywords.select_user_title')]]
	</h4>
      </div>
      <div class="modal-body">
	<div class="container-scrollable">
	  <form id="user-select" name="user-select">
	    <div ng-repeat="user in users | orderBy:'firstname'">
	      <div ng-hide="(user.is_current_user)">
		<div class="user-row">
		  <i class="fa fa-warning" title="[[Lang::get('keywords.owner_warning')]]" ng-show="(user.owner)"></i>
		  {{ user.firstname }} {{user.lastname}}
		  <select class="perm-select" ng-model="user.umask" ng-options="u.value as (u.name) for u in umasks">
		  </select>
		</div>
	      </div>
	      <div ng-show="(user.is_current_user)">
		<div class="user-row">
		  {{ user.firstname }} {{user.lastname}}
		  <div class="perm-select">
		  [[Lang::get('keywords.current_user')]]
		  </div>
		</div>
	      </div>
	    </div>
	  </form>
	</div>
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-default pull-left" ng-click="modalUsersSelectInherit(modalMessageBox.notebookId)">[[Lang::get('keywords.inherit_from_notebook')]]</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
	<button type="button" class="btn btn-primary" ng-click="modalUsersSelectSubmit(modalMessageBox.notebookId, modalMessageBox.noteId, users)">[[Lang::get('keywords.select')]]</button>
      </div>
      [[ Form::close() ]]
    </div>
  </div>
</div>
