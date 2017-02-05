angular.module('paperworkNotes').factory('NotesService',
  function($rootScope, $http, base64, NetService, paperworkDbAllId, StatusNotifications) {
    var factory = {};

    // paperworkNotesServiceFactory.selectedNoteIndex = 0;

    factory.createNote = function(notebookId, data, callback) {
      NetService.apiPost('/notebooks/' + notebookId + '/notes', data, callback);
    };

     factory.updateNote = function(noteId, data, callback) {
       NetService.apiPut('/notebooks/' + paperworkDbAllId + '/notes/' + noteId, data, callback);
     };

     factory.deleteNote = function(noteId, callback) {
       NetService.apiDelete('/notebooks/' + paperworkDbAllId + '/notes/' + noteId, callback);
     };

    factory.moveNote = function(notebookId, noteId, toNotebookId, callback) {
      NetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/move/' + toNotebookId, function(status, data) {
        if(status == 200) {
          // $rootScope.notes = data.response;
          if(typeof callback != "undefined") {
            callback(notebookId, noteId, toNotebookId);
          }
          StatusNotifications.sendStatusFeedback("success", "note_moved_successfully");
        }else{
          StatusNotifications.sendStatusFeedback("error", "note_move_fail");
        }
      });
    };

    factory.tagNote = function(notebookId, noteId, toTagId, callback) {
      console.log("test");
      NetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/tag/' + toTagId, function(status, data) {
        if(status == 200) {
          StatusNotifications.sendStatusFeedback("success", "note_tag_success");
        }else{
          StatusNotifications.sendStatusFeedback("error", "note_tag_fail");
        }
      });
    };

    factory.shareNote = function(notebookId,noteId,toUserId,toUMASK,callback){
      NetService.apiGet('/notebooks/'+notebookId+'/notes/'+noteId+'/share/'+toUserId+'/'+toUMASK, function(status,data){
        if (status==200) {
          if(typeof callback != "undefined") {
            callback(notebookId, noteId);
            }
          StatusNotifications.sendStatusFeedback("success", "note_share_success");
        }else{
          StatusNotifications.sendStatusFeedback("error", "note_share_fail");
        }
      });
    };
    
    factory.getNotesInNotebook = function(notebookId, callback) {
      NetService.apiGet('/notebooks/' + notebookId + '/notes', function(status, data) {
        if(status == 200) {
          $rootScope.notes = data.response;
          if(typeof callback != "undefined") {
            callback();
          }
        }
      });
    };

    factory.getNotesInTag = function(tagId) {
      NetService.apiGet('/tagged/' + tagId, function(status, data) {
        if(status == 200) {
          $rootScope.notes = data.response;
        }
      });
    };

     factory.getNoteById = function(noteId, callback) {
       NetService.apiGet('/notebooks/' + paperworkDbAllId + '/notes/' + noteId, function(status, data) {
         if(status == 200) {
           $rootScope.note = data.response;
           if(typeof callback != "undefined") {
             callback(data.response);
           }
         }
       });
     };

    factory.getNotesFromSearch = function(query) {
      NetService.apiGet('/search/' + base64.encode(query), function(status, data) {
        if(status == 200) {
          $rootScope.notes = data.response;
        }
      });
    };

    factory.getNoteVersionAttachments = function(notebookId, noteId, versionId, callback) {
      NetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments', function(status, data) {
        if(status == 200) {
          if(typeof callback != "undefined") {
            callback(data.response);
          }
        }
      });
    };

    factory.deleteNoteVersionAttachment = function(notebookId, noteId, versionId, attachmentId, callback) {
      NetService.apiDelete('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments/' + attachmentId, callback);
    };

    return factory;
  });
