angular.module('paperworkNotes').controller('FourOhFourController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService',
    function($scope, $rootScope, $location, $routeParams, notesService) {
      $rootScope.navbarMainMenu = true;
      $rootScope.navbarSearchForm = true;
      $rootScope.expandedNoteLayout = false;
    }]);
