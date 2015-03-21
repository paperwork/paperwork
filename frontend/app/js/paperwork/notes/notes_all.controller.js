angular.module('paperworkNotes').controller('NotesAllController',
  function($scope, $rootScope, $location, $routeParams, NotesService) {
    if(typeof $routeParams == "undefined" || $routeParams == {} || typeof $routeParams.notebookId == "undefined") {
      return;

       // fixme
       // $rootScope.notebookSelectedId = 0;
     } else {
       $rootScope.notebookSelectedId = ($routeParams.notebookId);
     }
     NotesService.getNotesInNotebook($rootScope.getNotebookSelectedId(), function() {
       // $rootScope.setNoteSelectedId($rootScope.getNotebookSelectedId(), $rootScope.notes[0].id);
       if($rootScope.notes.length > 0) {
         $location.path("/n/" + $scope.notebookSelectedId + "/" + $rootScope.notes[0].id);
       }
     });

    $rootScope.editMultipleNotes = false;
    $rootScope.navbarMainMenu = true;
    $rootScope.navbarSearchForm = true;
    $rootScope.expandedNoteLayout = false;

    $rootScope.note = null;
  });
