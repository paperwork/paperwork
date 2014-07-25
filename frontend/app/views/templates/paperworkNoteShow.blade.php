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
		      		<a href="#/n/{{note.notebook_id}}/{{note.id}}/edit" class="btn btn-default navbar-btn"><i class="fa fa-pencil-square-o"></i></a>
		      		<button class="btn btn-default navbar-btn"><i class="fa fa-share-alt"></i></button>
		      		<button class="btn btn-danger navbar-btn"><i class="fa fa-trash-o"></i></button>
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
			<div class="freqselector-item freqselector-item-not-dummy">
			<div id="freqselector-item-1" class="freqselector-item-snap"></div>
				<div>
					<div class="freqselector-item-title">19.07.2014</div>
					<div class="freqselector-item-subtitle">23:05</div>
				</div>
			</div>
			<div class="freqselector-item freqselector-item-not-dummy">
				<div id="freqselector-item-2" class="freqselector-item-snap"></div>
				<div>
					<div class="freqselector-item-title">20.07.2014</div>
					<div class="freqselector-item-subtitle">14:09</div>
				</div>
			</div>
			<div class="freqselector-item freqselector-item-not-dummy">
				<div id="freqselector-item-3" class="freqselector-item-snap"></div>
				<div>
					<div class="freqselector-item-title">21.07.2014</div>
					<div class="freqselector-item-subtitle">15:22</div>
				</div>
			</div>
			<div class="freqselector-item freqselector-item-not-dummy">
				<div id="freqselector-item-4" class="freqselector-item-snap"></div>
				<div>
					<div class="freqselector-item-title">23.07.2014</div>
					<div class="freqselector-item-subtitle">09:53</div>
				</div>
			</div>
			<div class="freqselector-item freqselector-item-dummy">
				<div id="freqselector-item-5" class="freqselector-item-snap"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>


<div>
	<div class="page-header"><h1>{{note.title}}</h1></div>
	<div class="page-content">
		{{note.content}}
	</div>
</div>
</div>
