angular.module('paperworkNotes').controller('FourOhFourController',
  function($scope, $rootScope, $location, $routeParams, NotesService) {
    $rootScope.navbarMainMenu = true;
    $rootScope.navbarSearchForm = true;
    $rootScope.expandedNoteLayout = false;
  });
