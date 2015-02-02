angular.module('paperworkNotes').controller('SearchController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService',
   function($scope, $rootScope, $location, $routeParams, notesService) {
     var sQ = $routeParams.searchQuery;

     $rootScope.search = sQ;

     var searchMatch = /([a-zA-Z]+)(?:\:(\d+))?(\/.+)?/g.exec(sQ);
     if(typeof searchMatch != "undefined" && searchMatch != null && searchMatch.length > 0) {
       switch(searchMatch[1]) {
         case "tagid":
           notesService.getNotesInTag(searchMatch[2]);
           break;
         default:
           notesService.getNotesFromSearch(searchMatch[0]);
           break;
       }
       $rootScope.note = null;
     }

     $rootScope.navbarMainMenu = true;
     $rootScope.navbarSearchForm = true;
     $rootScope.expandedNoteLayout = false;
   }]);
