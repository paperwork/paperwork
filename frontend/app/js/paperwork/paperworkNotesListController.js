paperworkModule.controller('paperworkNotesListController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
    $rootScope.noteSelectedId = {};
    $rootScope.notesSelectedIds = [];
    paperworkNotesService.getNotesInNotebook(paperworkNotebookAllID);

    $scope.noteSelect = function($notebookId, $noteId) {
      $rootScope.noteSelectedId = { 'notebookId': ($notebookId), 'noteId': ($noteId) };
    }

    $scope.getNoteLink = function(notebookId, noteId) {

      var path = "/n/" + (notebookId) + "/" + (noteId);
      if($location.$$path.match(/^\/s\//i) != null) {
        var basePath = $location.$$path.match(/(^\/s\/[^\/]*)/i);
        return basePath[1] + path;
      }
      return path;
    };

});