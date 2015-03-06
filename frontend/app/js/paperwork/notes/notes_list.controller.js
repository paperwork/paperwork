angular.module('paperworkNotes').controller('NotesListController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService',
    function($scope, $rootScope, $location, $routeParams, notesService) {
    $rootScope.noteSelectedId = {};
    $rootScope.notesSelectedIds = [];
    notesService.getNotesInNotebook(0);

    $scope.noteSelect = function($notebookId, $noteId) {
      $rootScope.noteSelectedId = { 'notebookId': parseInt($notebookId), 'noteId': parseInt($noteId) };
    };

    $scope.getNoteLink = function(notebookId, noteId) {

      var path = "/n/" + parseInt(notebookId) + "/" + parseInt(noteId);
      if($location.$$path.match(/^\/s\//i) != null) {
        var basePath = $location.$$path.match(/(^\/s\/[^\/]*)/i);
        return basePath[1] + path;
      }
      return path;
    };

}]);
