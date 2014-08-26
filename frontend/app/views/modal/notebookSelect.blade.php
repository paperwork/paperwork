<div ng-controller="paperworkSidebarNotebooksController" class="modal fade" id="modalNotebookSelect" tabindex="-1" role="dialog" aria-labelledby="modalNotebookSelectLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			[[ Form::open(array('class' => 'form-signin', 'role' => 'form')) ]]
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modalNotebookSelectLabel">
					[[Lang::get('keywords.select_notebook_title')]]
				</h4>
			</div>
			<div class="modal-body">
				<!-- TODO: Notebooks list here -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
				<button type="button" class="btn btn-primary" ng-click="modalNotebookSelectSubmit()">[[Lang::get('keywords.select')]]</button>
			</div>
			[[ Form::close() ]]
		</div>
	</div>
</div>
