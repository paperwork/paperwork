paperworkModule.controller('paperworkSearchController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  var sQ = $routeParams.searchQuery;

  $rootScope.search = sQ;

  var tagId = sQ.match(/tagid\:([0-9]+)/i);
  if(tagId != null) {
    $rootScope.notes = paperworkNotesService.getNotesInTag(tagId[1]);
    $rootScope.note = null;
    // $rootScope.noteSelectedId = -1;
  }
  $rootScope.navbarMainMenu = true;
  $rootScope.navbarSearchForm = true;
  $rootScope.expandedNoteLayout = false;
});