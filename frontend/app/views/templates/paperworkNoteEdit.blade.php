<div ng-controller="FileUploadController" class="file-upload-wrapper" uploader="uploader" nv-file-drop="" uploader="uploader" filters="queueLimit, customFilter">
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
		    <div class="collapse navbar-collapse" id="navbar-paperwork-note-edit">
		      <ul class="nav navbar-nav">
		      	<li>
			      	<div class="btn-group">
<!-- 			      		<button ng-controller="SidebarNotesController" class="btn btn-default navbar-btn"><i class="fa fa-book"></i> {{templateNoteEdit.notebook_title}}</button>
			      		<button class="btn btn-default navbar-btn"><i class="fa fa-tags"></i></button> -->
		      		</div>
		      	</li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		      	<li>
			      	<div class="btn-group" ng-controller="SidebarNotesController">
			      		<a id="updateNote" href="" ng-click="updateNote()" class="btn btn-default navbar-btn" title="[[Lang::get('keywords.save')]]"><i class="fa fa-floppy-o"></i></a>
			      		<a href="" ng-click="closeNote()" class="btn btn-default navbar-btn" title="[[Lang::get('keywords.close')]]"><i class="fa fa-times-circle"></i></a>
		      		</div>
		      	</li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>

	<div class="container-fluid">
  		<div class="row">
  			<div class="col-md-9">
				<form role="form" class="padding-twenty">
					<div>
						<div class="page-header">
							<div class="form-group {{ errors.title ? 'has-error' : '' }}">
								<input type="text" class="form-control input-lg" id="title" placeholder="[[Lang::get('keywords.note_title')]]" ng-model="templateNoteEdit.title">
							</div>
							<div class="form-group {{ errors.tags ? 'has-error' : '' }}">
								<input type="text" class="form-control input-lg" id="tags" placeholder="[[Lang::get('keywords.tags_separated')]]">
							</div>
						</div>
						<div class="page-content">
							<textarea id="content" class="form-control" rows="16" ng-model="templateNoteEdit.content"></textarea>
						</div>
					</div>
				</form>
  			</div>
  			<div class="col-md-3">
  				@include('partials/file-uploader', array('uploadEnabled' => true, 'actionsEnabled' => true))
  			</div>
  		</div>
	</div>
</div>
