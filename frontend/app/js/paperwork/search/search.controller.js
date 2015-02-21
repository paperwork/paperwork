angular.module('paperworkNotes').controller('SearchController',
  function($scope, $rootScope, $location, $routeParams, notesService) {
    var searchQuery = $routeParams.searchQuery;

    $rootScope.search = searchQuery;

    notesService.getNotesFromSearch(searchQuery);
    $rootScope.note = null;

    $rootScope.navbarMainMenu = true;
    $rootScope.navbarSearchForm = true;
    $rootScope.expandedNoteLayout = false;
  });
