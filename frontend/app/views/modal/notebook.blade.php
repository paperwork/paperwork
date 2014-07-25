<div ng-controller="paperworkSidebarNotebooksController" class="modal fade" id="modalNotebook" tabindex="-1" role="dialog" aria-labelledby="modalNotebookLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
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
				<div class="checkbox" ng-show="modalNotebook.action == 'edit'">
					<label>
						<input type="checkbox" name="delete" ng-model="modalNotebook.delete"> [[Lang::get('notebooks.delete_notebook')]]
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
				<button type="button" class="btn {{ modalNotebook.delete ? 'btn-danger' : 'btn-primary' }}" ng-click="modalNotebookSubmit()">
					{{ modalNotebook.action == 'create' ? '[[Lang::get('keywords.create')]]' : '' }}
					{{ modalNotebook.action == 'edit' ? (modalNotebook.delete ? '[[Lang::get('keywords.delete')]]' : '[[Lang::get('keywords.update')]]') : '' }}
				</button>
			</div>
			[[ Form::close() ]]
		</div>
	</div>
</div>
