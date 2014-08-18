paperworkModule.controller('paperworkNotesListController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
    $rootScope.noteSelectedId = {};
    paperworkNotesService.getNotesInNotebook(0);

    $scope.noteSelect = function($notebookId, $noteId) {
      $rootScope.noteSelectedId = { 'notebookId': parseInt($notebookId), 'noteId': parseInt($noteId) };
    }

    $scope.getNoteLink = function(notebookId, noteId) {

      var path = "/n/" + parseInt(notebookId) + "/" + parseInt(noteId);
      if($location.$$path.match(/^\/s\//i) != null) {
        var basePath = $location.$$path.match(/(^\/s\/[^\/]*)/i);
        return basePath[1] + path;
      }
      return path;
    };

});