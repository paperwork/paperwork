angular.module('paperworkNotes').controller('NotesShowController',
  function($scope, $rootScope, $location, $routeParams, NotesService, NetService) {
    if(!angular.isNumber(parseInt($routeParams.noteId)) || $routeParams.noteId === "undefined") {
      return;
    }

    $rootScope.notebookSelectedId = parseInt($routeParams.notebookId);
    $rootScope.noteSelectedId = {'notebookId': parseInt($routeParams.notebookId), 'noteId': parseInt($routeParams.noteId)};
    $rootScope.versionSelectedId = {'notebookId': parseInt($routeParams.notebookId), 'noteId': parseInt($routeParams.noteId), 'versionId': 0};

    if(typeof $routeParams.searchQuery == "undefined" || $routeParams.searchQuery == null || $routeParams.searchQuery.length <= 0) {
      NotesService.getNotesInNotebook($rootScope.getNotebookSelectedId());
    }

    NotesService.getNoteById(parseInt($routeParams.noteId));

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
