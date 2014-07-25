<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Paperwork</title>

	[[ HTML::style('css/bootstrap.min.css') ]]
    [[ HTML::style('css/bootstrap-theme.min.css') ]]

    [[ HTML::style('css/bootstrap-tagsinput.min.css') ]]

    [[ HTML::style('css/paperwork.min.css') ]]


</head>
  <body ng-app="paperworkNotes">

	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">[[Lang::get('keywords.toggle_navigation')]]</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand transition-effect" href="#">Paperworks</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="[[ URL::route("/") ]]" class="transition-effect"><i class="fa fa-book"></i> [[Lang::get('keywords.library')]]</a></li>
					<li><a href="[[ URL::route("user/profile") ]]" class="transition-effect"><i class="fa fa-user"></i> [[Lang::get('keywords.profile')]]</a></li>
					<li><a href="[[ URL::route("user/settings") ]]" class="transition-effect"><i class="fa fa-cog"></i> [[Lang::get('keywords.settings')]]</a></li>
					<li><a href="[[ URL::route("user/help") ]]" class="transition-effect"><i class="fa fa-question"></i> [[Lang::get('keywords.help')]]</a></li>
					<li><a href="[[ URL::route("user/logout") ]]" class="transition-effect"><i class="fa fa-sign-out"></i> [[Lang::get('keywords.sign_out')]]</a></li>
				</ul>
			</div>
		</div>
	</div>

	@yield("content")

	[[ HTML::script('js/jquery.min.js') ]]
	[[ HTML::script('js/jquery.overscroll.min.js') ]]
	[[ HTML::script('js/jquery.scrollTo.min.js') ]]

	[[ HTML::script('js/angular.min.js') ]]
	[[ HTML::script('js/angular-resource.min.js') ]]
	[[ HTML::script('js/angular-route.min.js') ]]

	<!-- [[ HTML::script('js/typeahead.min.js') ]] -->

	<!-- [[ HTML::script('js/bootstrap-tagsinput.min.js') ]] -->
	<!-- [[ HTML::script('js/bootstrap-tagsinput-angular.min.js') ]] -->

	[[ HTML::script('js/paperwork-note.min.js') ]]

	[[ HTML::script('js/transition.min.js') ]]
	[[ HTML::script('js/collapse.min.js') ]]

	[[ HTML::script('js/bootstrap-tree.min.js') ]]
	[[ HTML::script('js/bootstrap-modal.min.js') ]]

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	[[ HTML::script('js/ie10-viewport-bug-workaround.js') ]]



<script type="text/javascript">
$(document).ready(function() {
	window.setupWaybackTimeline = function() {
		var $_timeline = jQuery('.wayback-timeline');
		var $_timelineParent = $_timeline.parent();
		var $_timelineBackground = $_timeline.find('.background');
		var $_timelineArrow = $_timeline.find('.arrow-top');
		var $_timelineContent = $_timeline.find('.content');
		var arrowLeft;
		var arrowCenterOffset = 11;

		jQuery('#noteHistory').on('click', function() {
			$_timeline.animate({
			    // opacity: 0.0,
			    // left: "+=50",
			    height: "toggle"
			  }, "fast", function() {
	    		$_timelineBackground.scrollTo('#'+$_timelineContent.find('.item-not-dummy').last().children('.item-snap').attr('id'), 1000, { offset: (0 - arrowLeft - arrowCenterOffset + $_timeline.offset().left), axis: 'x' });
			  });
		});

		var resizeTimelineContent = function() {
			var newWidth = 0;

			$_timeline.find('.item').each(function() {
				newWidth += jQuery(this).width() + 4;
			});

			$_timelineContent.width(newWidth);
			arrowLeft = Math.abs($_timelineArrow.offset().left);
		}

		jQuery(window).resize(function() {
			// var documentWidth = jQuery(document).width() / 2;
			var documentWidth = Math.round($_timelineParent.width() / 2);
			$_timeline.find('.item-dummy').width(documentWidth);
			resizeTimelineContent();
		});

		jQuery(window).resize();
		resizeTimelineContent();

	    $_timelineBackground.overscroll({
	    	showThumbs: false,
	    	direction: 'horizontal',
	    	wheelDirection: 'horizontal',
	    	openedCursor: '',
	    	closedCursor: ''
	    	// captureWheel: false
	    }).on('overscroll:driftend', function() {
	    		//$_timelineBackground.scrollLeft();

	    		var resultsArray = new Array();

	    		$_timeline.find('.item-snap').each(function() {
	    			//var itemDistance = arrowLeft - jQuery(this).offset().left;
	    			var itemDistance = jQuery(this).offset().left;
	    			var itemId = jQuery(this).attr('id').replace(/timeline-item-/, "");
	    			resultsArray.push({ 'id': itemId, 'distance': itemDistance });
	    		});

			    var closest = null;
			    var prev = Math.abs(resultsArray[0].distance - arrowLeft - arrowCenterOffset);
			    for (var i = 1; i < resultsArray.length; i++) {
			        var diff = Math.abs(resultsArray[i].distance - arrowLeft - arrowCenterOffset);
			        if (diff < prev) {
			            prev = diff;
			            closest = resultsArray[i];
			        }
			    }

			    if(closest != null)
			    {
					$_timelineBackground.scrollTo('#timeline-item-'+closest.id, 500, { offset: (0 - arrowLeft - arrowCenterOffset + $_timeline.offset().left), axis: 'x' });
				}
	    });
		$_timeline.hide();

	}
});
</script>

</body>
</html>
