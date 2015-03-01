<ul class="nav navbar-nav navbar-right">
	@include("partials.navbar.navbar-link", [
			"route" => URL::route("/"),
			"title" => Lang::get("keywords.library"), 
			"fa_icon" => "fa-book"
		])

	@include("partials.navbar.navbar-link", [
			"route" => URL::route("user/profile"),
			"title" => Lang::get("keywords.profile"), 
			"fa_icon" => "fa-user"
		])

	@include("partials.navbar.navbar-link", [
			"route" => URL::route("user/settings"),
			"title" => Lang::get("keywords.settings"), 
			"fa_icon" => "fa-cog"
		])

	@if (Auth::user() && Auth::user()->isAdmin())
		@include("partials.navbar.navbar-link", [
				"route" => URL::route("admin/console"),
				"title" => Lang::get("keywords.admin_area"), 
				"fa_icon" => "fa-star"
			])
	@endif

	@include("partials.navbar.navbar-link", [
			"route" => URL::route("user/help"),
			"title" => Lang::get("keywords.help"), 
			"fa_icon" => "fa-question"
		])
	@include("partials.navbar.navbar-link", [
			"route" => URL::route("user/logout"),
			"title" => Lang::get("keywords.sign_out"), 
			"fa_icon" => "fa-sign-out"
		])
</ul>
