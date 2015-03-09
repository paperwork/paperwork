angular.module('paperworkNotes').factory('NotesService',
  function($rootScope, $http, base64, NetService) {
    var paperworkNotesServiceFactory = {};

    // paperworkNotesServiceFactory.selectedNoteIndex = 0;

    paperworkNotesServiceFactory.createNote = function(notebookId, data, callback) {
      NetService.apiPost('/notebooks/' + notebookId + '/notes', data, callback);
    };

     paperworkNotesServiceFactory.updateNote = function(noteId, data, callback) {
       NetService.apiPut('/notebooks/' + paperworkDbAllId + '/notes/' + noteId, data, callback);
     };

     paperworkNotesServiceFactory.deleteNote = function(noteId, callback) {
       NetService.apiDelete('/notebooks/' + paperworkDbAllId + '/notes/' + noteId, callback);
     };

    paperworkNotesServiceFactory.moveNote = function(notebookId, noteId, toNotebookId, callback) {
      NetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/move/' + toNotebookId, function(status, data) {
        if(status == 200) {
          // $rootScope.notes = data.response;
          if(typeof callback != "undefined") {
            callback(notebookId, noteId, toNotebookId);
          }
        }
      });
    };

    paperworkNotesServiceFactory.tagNote = function(notebookId, noteId, toTagId, callback) {
      console.log("test");
      NetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/tag/' + toTagId, function(status, data) {
        //
      });
    };

    paperworkNotesServiceFactory.getNotesInNotebook = function(notebookId, callback) {
      NetService.apiGet('/notebooks/' + notebookId + '/notes', function(status, data) {
        if(status == 200) {
          $rootScope.notes = data.response;
          if(typeof callback != "undefined") {
            callback();
          }
        }
      });
    };

    paperworkNotesServiceFactory.getNotesInTag = function(tagId) {
      NetService.apiGet('/tagged/' + tagId, function(status, data) {
        if(status == 200) {
          $rootScope.notes = data.response;
        }
      });
    };

     paperworkNotesServiceFactory.getNoteById = function(noteId, callback) {
       NetService.apiGet('/notebooks/' + paperworkDbAllId + '/notes/' + noteId, function(status, data) {
         if(status == 200) {
           $rootScope.note = data.response;
           if(typeof callback != "undefined") {
             callback(data.response);
           }
         }
       });
     };

    paperworkNotesServiceFactory.getNotesFromSearch = function(query) {
      NetService.apiGet('/search/' + base64.encode(query), function(status, data) {
        if(status == 200) {
          $rootScope.notes = data.response;
        }
      });
    };

    paperworkNotesServiceFactory.getNoteVersionAttachments = function(notebookId, noteId, versionId, callback) {
      NetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments', function(status, data) {
        if(status == 200) {
          if(typeof callback != "undefined") {
            callback(data.response);
          }
        }
      });
    };

    paperworkNotesServiceFactory.deleteNoteVersionAttachment = function(notebookId, noteId, versionId, attachmentId, callback) {
      NetService.apiDelete('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments/' + attachmentId, callback);
    };

    return paperworkNotesServiceFactory;
  });
