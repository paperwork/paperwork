paperworkModule.controller('paperworkSearchController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  var sQ = $routeParams.searchQuery;

  $rootScope.search = sQ;

  var searchMatch = /([a-zA-Z]+)(\:(\d+))?(\/.+)?/g.exec(sQ);
  if(typeof searchMatch != "undefined" && searchMatch != null && searchMatch.length > 0) {
    switch(searchMatch[1]) {
      case "tagid":
        paperworkNotesService.getNotesInTag(searchMatch[3]);
      break;
      default:
        paperworkNotesService.getNotesFromSearch(searchMatch[0]);
      break;
    }
    $rootScope.note = null;
  }

  $rootScope.navbarMainMenu = true;
  $rootScope.navbarSearchForm = true;
  $rootScope.expandedNoteLayout = false;
});