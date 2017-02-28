angular.module('paperworkNotes').controller('NotesListController',
  function($scope, $rootScope, $location, $routeParams, NotesService, paperworkDbAllId) {
    $rootScope.noteSelectedId = {};
    $rootScope.notesSelectedIds = {};
    NotesService.getNotesInNotebook(paperworkDbAllId);

    $scope.noteSelect = function($notebookId, $noteId) {
      $rootScope.noteSelectedId = { 'notebookId': ($notebookId), 'noteId': ($noteId) };
    };

    $scope.getNoteLink = function(notebookId, noteId) {

      var path = "/n/" + (notebookId) + "/" + (noteId);
      if($location.$$path.match(/^\/s\//i) != null) {
        var basePath = $location.$$path.match(/(^\/s\/[^\/]*)/i);
        return basePath[1] + path;
      }
      return path;
    };
      //$scope.noteSelectedId=$rootScope.noteSelectedId;
      $scope.openSelectedNote = function(){
	  $location.path("/n/" + ($rootScope.notebookSelectedId)+"/"+($rootScope.noteSelectedId.noteId));
      };
  });
