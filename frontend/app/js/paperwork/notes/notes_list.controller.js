angular.module('paperworkNotes').controller('NotesListController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService',
    function($scope, $rootScope, $location, $routeParams, notesService) {
    $rootScope.noteSelectedId = {};
    $rootScope.notesSelectedIds = [];
    notesService.getNotesInNotebook(paperworkDbAllId);

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

}]);
