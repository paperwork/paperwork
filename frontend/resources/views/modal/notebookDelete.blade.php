<div ng-controller="SidebarNotebooksController" class="modal fade" id="modalNotebookDelete" tabindex="-1" role="dialog" aria-labelledby="modalNotebookDeleteLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" accept-charset="UTF-8" class="form ng-pristine ng-invalid ng-invalid-required" role="form" ng-submit="modalNotebookDeleteSubmit()">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="modalNotebookDeleteLabel">[[ Lang::get('keywords.delete_notebook_question') ]]</h4>
				</div>
				<div class="modal-body">
					<div class="form-group [[ $errors->first('title') ? 'has-error' : '' ]]">
						[[ Lang::get('keywords.delete_notebook_message') ]]
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="delete_notes_inside" ng-model="modalNotebookDelete.delete_notes"> [[Lang::get('notebooks.delete_notes_inside')]]
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
					<button type="button" class="btn btn-warning" ng-click="modalNotebookDeleteSubmit()">[[ Lang::get('keywords.yes') ]]</button>
				</div>
			</form>
		</div>
	</div>
</div>
