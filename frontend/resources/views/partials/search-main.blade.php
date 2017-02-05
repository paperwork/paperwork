<form ng-controller="SidebarNotesController" ng-cloak ng-show="navbarSearchForm" class="navbar-form navbar-left animate-panel" id="searchForm" role="form" ng-submit="submitSearch()">
	<div class="form-group">
		<input type="text" class="form-control navbar-search" placeholder="[[Lang::get('keywords.search_dotdotdot')]]" ng-model="search">
	</div>
</form>
