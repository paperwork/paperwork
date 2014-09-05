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
				<select name="notebook-select" id="notebook-select">
					<optgroup ng-repeat="notebook in notebooks | orderBy:'title'">
						<option ng-hide="notebook.children.length > 0" value="{{ notebook.id }}">{{ notebook.title }}</option>
						<optgroup ng-hide="notebook.children.length > 0" label="{{ notebook.title }}">
							<option ng-repeat="child in notebook.children | orderBy:'title'" value="{{ child.id }}">{{ child.title }}</option>
						</optgroup>
					</optgroup>
				</select>

<!-- 				<ul class="tree-child">
					<li class="tree-notebook" ng-repeat="notebook in notebooks | orderBy:'title'">
						<span ng-click="openNotebook(notebook.id, notebook.type, notebook.id)" ng-class="{ 'active': notebook.id == getNotebookSelectedId() }"><i class="fa {{ notebookIconByType(notebook.type) }}"></i> {{notebook.title}}</span>
						<ul class="tree-child">
							<li class="tree-notebook" ng-repeat="child in notebook.children | orderBy:'title'">
								<span ng-click="openNotebook(child.id, child.type, child.id)" ng-class="{ 'active': child.id == getNotebookSelectedId() }"><i class="fa {{ notebookIconByType(child.type) }}"></i> {{child.title}}</span>
							</li>
						</ul>
					</li>
				</ul> -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">[[Lang::get('keywords.cancel')]]</button>
				<button type="button" class="btn btn-primary" ng-click="modalNotebookSelectSubmit()">[[Lang::get('keywords.select')]]</button>
			</div>
			[[ Form::close() ]]
		</div>
	</div>
</div>
