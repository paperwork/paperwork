<div ng-controller="paperworkSidebarNotebooksController" class="modal fade" id="modalNewNotebook" tabindex="-1" role="dialog" aria-labelledby="modalNewNotebookLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modalNewNotebookLabel">[[Lang::get('notebooks.title_new_notebook')]]</h4>
			</div>
			<div class="modal-body">
				<div class="form-group [[ $errors->first('title') ? 'has-error' : '' ]]">
					[[ Form::text('title', '', array('ng-model' => 'createNotebookTitle', 'class' => 'form-control', 'placeholder' => Lang::get('notebooks.notebook_title'), 'required', 'autofocus')) ]]
				</div>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="add_shortcut" ng-model="createNotebookShortcut"> [[Lang::get('notebooks.add_shortcut')]]
					</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
				<button type="button" class="btn btn-primary" ng-click="createNotebook()">[[Lang::get('keywords.create')]]</button>
			</div>
			[[ Form::close() ]]
		</div>
	</div>
</div>
