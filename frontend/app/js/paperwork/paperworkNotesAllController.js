paperworkModule.controller('paperworkNotesAllController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
    if(typeof $routeParams == "undefined" || $routeParams == {} || typeof $routeParams.notebookId == "undefined") {
      return;
      $rootScope.notebookSelectedId = 0;
    } else {
      $rootScope.notebookSelectedId = parseInt($routeParams.notebookId);
    }
    paperworkNotesService.getNotesInNotebook($rootScope.getNotebookSelectedId(), function() {
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