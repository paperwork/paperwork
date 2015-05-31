<div ng-controller="SidebarNotebooksController" class="modal fade" id="modalUsersNotebookSelect" tabindex="-1" role="dialog" aria-labelledby="modalUsersNotebookSelectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      [[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
      <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title" id="modalUsersSelectLabel">
	  [[Lang::get('keywords.select_user_notebook_title')]]
	</h4>
      </div>
      <div class="modal-body">
	<div class="container-scrollable">
	  <form id="user-select" name="user-select">
	    <div ng-repeat="user in users | orderBy:'firstname'">
	      <div ng-hide="(user.umask == 7)">
		<div class="user-row">
		  {{ user.firstname }} {{user.lastname}}
		  <select class="perm-select" ng-model="user.umask" ng-options="u.value as (u.name) for u in umasks">
		  </select>
		</div>
	      </div>
	    </div>
	  </form>
	</div>
	  <div class="checkbox">
	    <label>
	      <input type="checkbox" name="permission_propagation" ng-model="propagationToNotes"> [[Lang::get('keywords.propagate_permissions')]]
	    </label>
	  </div>	
      </div>
      <div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
	<button type="button" class="btn btn-primary" ng-click="modalUsersNotebookSelectSubmit(modalMessageBox.notebookId, users, propagationToNotes)">[[Lang::get('keywords.select')]]</button>
      </div>
      [[ Form::close() ]]
    </div>
  </div>
</div>
