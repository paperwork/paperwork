<div ng-controller="SidebarNotebooksController" class="modal fade" id="modalNotebookSelect" tabindex="-1" role="dialog" aria-labelledby="modalNotebookSelectLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modalNotebookSelectLabel">
					[[--Lang::get('keywords.select_notebook_title')--]]
					{{ modalMessageBox.header }}
				</h4>
			</div>
			<div class="modal-body">
			    <div ng-if="(modalMessageBox.description)">
			        <p>{{ modalMessageBox.description }}</p> 
			    </div>
				<div class="container-scrollable">
					<div class="container">
						<form id="notebook-select" name="notebook-select">
							<div ng-repeat="notebook in notebooks | orderBy:'title'">
								<div ng-hide="(notebook.id == 0 || notebook.id == modalMessageBox.notebookId)">
									<div class="radio">
										<label>
											<input type="radio" name="notebookSelectedModel" ng-model="$parent.notebookSelectedModel" value="{{ notebook.id }}"> {{ notebook.title }}
										</label>
									</div>
								</div>
								<div ng-repeat="child in notebooks.children | orderBy:'title'">
									<div class="radio">
										<label>
											<input type="radio" name="notebookSelectedModel" ng-model="$parent.notebookSelectedModel" value="{{ child.id }}"> {{ child.title }}
										</label>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
				<button type="button" class="btn btn-primary" ng-click="modalNotebookSelectSubmit(modalMessageBox.notebookId, modalMessageBox.noteId, notebookSelectedModel)">[[Lang::get('keywords.select')]]</button>
			</div>
			[[ Form::close() ]]
		</div>
	</div>
</div>
