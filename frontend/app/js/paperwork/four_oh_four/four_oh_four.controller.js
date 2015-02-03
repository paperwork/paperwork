angular.module('paperworkNotes').controller('FourOhFourController', function($scope, $rootScope, $location, $routeParams, notesService) {
      $rootScope.navbarMainMenu = true;
      $rootScope.navbarSearchForm = true;
      $rootScope.expandedNoteLayout = false;
    });
