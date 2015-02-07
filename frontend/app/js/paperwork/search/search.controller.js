angular.module('paperworkNotes').controller('SearchController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService',
   function($scope, $rootScope, $location, $routeParams, notesService) {
     var sQ = $routeParams.searchQuery;

     $rootScope.search = sQ;

     notesService.getNotesFromSearch(sQ);
     $rootScope.note = null;

     $rootScope.navbarMainMenu = true;
     $rootScope.navbarSearchForm = true;
     $rootScope.expandedNoteLayout = false;
   }]);
