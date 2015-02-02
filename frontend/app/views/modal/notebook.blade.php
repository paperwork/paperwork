<div ng-controller="SidebarNotebooksController" class="modal fade" id="modalNotebook" tabindex="-1" role="dialog" aria-labelledby="modalNotebookLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" accept-charset="UTF-8" class="form ng-pristine ng-invalid ng-invalid-required" role="form" ng-submit="modalNotebookSubmit()">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="modalNotebookLabel">
						{{ modalNotebook.action == 'create' ? '[[Lang::get('notebooks.title_new_notebook')]]' : '' }}
						{{ modalNotebook.action == 'edit' ? '[[Lang::get('notebooks.title_edit_notebook')]]' : '' }}
					</h4>
				</div>
				<div class="modal-body">
					<div class="form-group [[ $errors->first('title') ? 'has-error' : '' ]]">
						[[ Form::text('title', '', array('ng-model' => 'modalNotebook.title', 'class' => 'form-control', 'placeholder' => Lang::get('notebooks.notebook_title'), 'required', 'autofocus')) ]]
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" name="add_shortcut" ng-model="modalNotebook.shortcut"> [[Lang::get('notebooks.add_shortcut')]]
						</label>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
					<button type="button" class="btn btn-primary" ng-click="modalNotebookSubmit()">
						{{ modalNotebook.action == 'create' ? '[[Lang::get('keywords.create')]]' : '' }}
						{{ modalNotebook.action == 'edit' ? '[[Lang::get('keywords.update')]]' : '' }}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
