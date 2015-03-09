angular.module('paperworkNotes').controller('NotesShowController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService', 'NetService',
   function($scope, $rootScope, $location, $routeParams, notesService, netService) {
     if($routeParams.noteId === "undefined") {
       return;
     }

     $rootScope.notebookSelectedId = ($routeParams.notebookId);
     $rootScope.noteSelectedId = {'notebookId': ($routeParams.notebookId), 'noteId': ($routeParams.noteId)};
     $rootScope.versionSelectedId = {'notebookId': ($routeParams.notebookId), 'noteId': ($routeParams.noteId), 'versionId': paperworkDbAllId};

    if(typeof $routeParams.searchQuery == "undefined" || $routeParams.searchQuery == null || $routeParams.searchQuery.length <= 0) {
      NotesService.getNotesInNotebook($rootScope.getNotebookSelectedId());
    }

     notesService.getNoteById(($routeParams.noteId));

    NotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId, $rootScope.getVersionSelectedId(true).versionId,
      function(response) {
        $rootScope.fileList = response;
      });

    $('body').popover({
      selector:  '#note-info',
      container: 'body',
      viewport:  {
        selector: '#paperworkView',
        padding:  16
      },
      trigger:   'click',
      html:      true
    });

    $rootScope.navbarMainMenu = true;
    $rootScope.navbarSearchForm = true;
    $rootScope.expandedNoteLayout = false;
  });
