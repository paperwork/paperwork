<ul class="nav navbar-nav navbar-right">
	<li><a href="[[ URL::route("/") ]]" class="transition-effect"><i class="fa fa-book"></i> <span class="hidden-sm hidden-md">[[Lang::get('keywords.library')]]</span></a></li>
	<li><a href="[[ URL::route("user/profile") ]]" class="transition-effect"><i class="fa fa-user"></i> <span class="hidden-sm hidden-md">[[Lang::get('keywords.profile')]]</span></a></li>
	<li><a href="[[ URL::route("user/settings") ]]" class="transition-effect"><i class="fa fa-cog"></i> <span class="hidden-sm hidden-md">[[Lang::get('keywords.settings')]]</span></a></li>
	@if (Auth::user() && Auth::user()->isAdmin())
		<li><a href="[[ URL::route("admin/console") ]]" class="transition-effect"><i class="fa fa-star"></i> <span class="hidden-sm hidden-md">[[Lang::get('keywords.admin_area')]]</span></a></li>
	@endif
	<li><a href="[[ URL::route("user/help") ]]" class="transition-effect"><i class="fa fa-question"></i> <span class="hidden-sm hidden-md">[[Lang::get('keywords.help')]]</span></a></li>
	<li><a href="[[ URL::route("user/logout") ]]" class="transition-effect"><i class="fa fa-sign-out"></i> <span class="hidden-sm hidden-md">[[Lang::get('keywords.sign_out')]]</span></a></li>
</ul>
