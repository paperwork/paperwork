<div ng-controller="SidebarNotebooksController" class="modal fade" id="modalCollection" tabindex="-1" role="dialog" aria-labelledby="modalCollectionLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="POST" accept-charset="UTF-8" class="form ng-pristine ng-invalid ng-invalid-required" role="form" ng-submit="modalCollectionSubmit()">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="modalCollectionLabel">
						{{ modalCollection.action == 'create' ? '[[Lang::get('notebooks.title_new_collection')]]' : '' }}
						{{ modalCollection.action == 'edit' ? '[[Lang::get('notebooks.title_edit_collection')]]' : '' }}
					</h4>
				</div>
				<div class="modal-body">
					<div class="form-group [[ $errors->first('title') ? 'has-error' : '' ]]">
						[[ Form::text('title', '', array('ng-model' => 'modalCollection.title', 'class' => 'form-control', 'placeholder' => Lang::get('notebooks.collection_title'), 'required', 'autofocus')) ]]
					</div>
    				<div class="container-scrollable" id="modalCollectionNotebookCheckboxes">
    					<div class="container">
    						<div ng-repeat="notebook in writableNotebooks | orderBy:'title'">
    							<div ng-hide="(notebook.id == 0 || notebook.id == modalMessageBox.notebookId)">
    								<div class="checkbox">
    									<label>
    										<input type="checkbox" name="selectedNotebooksForCollection" ng-model="selectedNotebooksForCollection[notebook.id]" value="{{ notebook.id }}"> {{ notebook.title }}
    									</label>
    								</div>
    							</div>
    						</div>
    					</div>
    				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
					<button type="button" class="btn btn-primary" ng-click="modalCollectionSubmit()">
						{{ modalCollection.action == 'create' ? '[[Lang::get('keywords.create')]]' : '' }}
						{{ modalCollection.action == 'edit' ? '[[Lang::get('keywords.update')]]' : '' }}
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
