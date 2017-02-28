angular.module('paperworkNotes').controller('SearchController',
  function($scope, $rootScope, $location, $routeParams, NotesService) {
    var searchQuery = $routeParams.searchQuery;

    $rootScope.search = searchQuery;

    NotesService.getNotesFromSearch(searchQuery);
    $rootScope.note = null;

    $rootScope.navbarMainMenu = true;
    $rootScope.navbarSearchForm = true;
    $rootScope.expandedNoteLayout = false;
  });
