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
		      		<button id="noteHistory" class="btn btn-default navbar-btn"><i class="fa fa-history"></i></button>
		      		<a href="#/n/{{note.notebook_id}}/{{note.id}}/edit" class="btn btn-default navbar-btn"><i class="fa fa-pencil-square-o"></i></a>
		      		<button class="btn btn-default navbar-btn"><i class="fa fa-share-alt"></i></button>
		      		<button class="btn btn-danger navbar-btn"><i class="fa fa-trash-o"></i></button>
	      		</div>
	      	</li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

<div class="wayback-timeline">
	<!-- <div class="content-fadeout-bottom"></div> -->
	<div class="fadeout-left fadeout"></div>
	<div class="fadeout-right fadeout"></div>
	<div class="arrow-top"></div>
	<div class="arrow-bottom"></div>
	<div class="background">
		<div class="content">
			<div class="item item-dummy">
				<div id="timeline-item-0" class="item-snap"></div>
				<a><div>&nbsp;</div><div>&nbsp;</div></a>
			</div>
			<div class="item item-not-dummy">
			<div id="timeline-item-1" class="item-snap"></div>
				<div>
					<div class="item-title">19.07.2014</div>
					<div class="item-subtitle">23:05</div>
				</div>
			</div>
			<div class="item item-not-dummy">
				<div id="timeline-item-2" class="item-snap"></div>
				<div>
					<div class="item-title">20.07.2014</div>
					<div class="item-subtitle">14:09</div>
				</div>
			</div>
			<div class="item item-not-dummy">
				<div id="timeline-item-3" class="item-snap"></div>
				<div>
					<div class="item-title">21.07.2014</div>
					<div class="item-subtitle">15:22</div>
				</div>
			</div>
			<div class="item item-not-dummy">
				<div id="timeline-item-4" class="item-snap"></div>
				<div>
					<div class="item-title">23.07.2014</div>
					<div class="item-subtitle">09:53</div>
				</div>
			</div>
			<div class="item item-dummy">
				<div id="timeline-item-5" class="item-snap"></div>
				<a><div>&nbsp;</div><div>&nbsp;</div></a>
			</div>
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
