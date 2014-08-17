<div ng-hide="note == null">
<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      	<li>
		      	<div class="btn-group">
		      		<button class="btn btn-default navbar-btn"><i class="fa fa-book"></i> {{note.notebook_title}}</button>
		      		<button class="btn btn-default navbar-btn"><i class="fa fa-tags"></i></button>
	      		</div>
	      	</li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	      	<li>
		      	<div class="btn-group">
		      		<button class="btn btn-default navbar-btn"><i class="fa fa-info-circle"></i></button>
		      		<button class="btn btn-default navbar-btn" data-toggle="freqselector" data-target="#wayback-machine"><i class="fa fa-history"></i></button>
		      		<button class="btn btn-default navbar-btn"><i class="fa fa-share-alt"></i></button>
	      		</div>
	      	</li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div id="wayback-machine" class="freqselector">
	<div class="freqselector-fadeout-left freqselector-fadeout"></div>
	<div class="freqselector-fadeout-right freqselector-fadeout"></div>
	<div class="freqselector-arrow-top"></div>
	<div class="freqselector-arrow-bottom"></div>
	<div class="freqselector-background">
		<div class="freqselector-content">
			<div class="freqselector-item freqselector-item-dummy">
				<div id="freqselector-item-0" class="freqselector-item-snap"></div>
			</div>
			<div class="freqselector-item freqselector-item-not-dummy" ng-repeat="version in note.versions">
				<div id="freqselector-item-{{version.id}}" class="freqselector-item-snap" data-itemid="{{version.id}}" data-itemlatest="{{version.latest}}"></div>
				<div>
					<div class="freqselector-item-title">{{version.timestamp * 1000 | date:'yyyy-MM-dd'}}</div>
					<div class="freqselector-item-subtitle">{{version.timestamp * 1000 | date:'HH:mm'}}</div>
				</div>
			</div>
			<div class="freqselector-item freqselector-item-dummy">
				<div id="freqselector-item-999999" class="freqselector-item-snap"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>


<div class="padding-twenty">
	<div class="alert alert-info animate-fade" role="alert" ng-show="note.version > 0">
	[[Lang::get('messages.note_version_info')]]
	</div>
	<div class="page-header"><h1>{{note.title}}</h1></div>
	<div class="page-content" ng-bind-html="note.content">
	</div>
</div>
</div>
