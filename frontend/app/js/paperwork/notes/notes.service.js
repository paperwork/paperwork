angular.module('paperworkNotes').factory('NotesService',
  ['$rootScope', '$http', 'base64', 'NetService',
   function($rootScope, $http, base64, netService) {
     var paperworkNotesServiceFactory = {};

     // paperworkNotesServiceFactory.selectedNoteIndex = 0;

     paperworkNotesServiceFactory.createNote = function(notebookId, data, callback) {
       netService.apiPost('/notebooks/' + notebookId + '/notes', data, callback);
     };

     paperworkNotesServiceFactory.updateNote = function(noteId, data, callback) {
       netService.apiPut('/notebooks/0/notes/' + noteId, data, callback);
     };

     paperworkNotesServiceFactory.deleteNote = function(noteId, callback) {
       netService.apiDelete('/notebooks/0/notes/' + noteId, callback);
     };

     paperworkNotesServiceFactory.moveNote = function(notebookId, noteId, toNotebookId, callback) {
       netService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/move/' + toNotebookId, function(status, data) {
         if(status == 200) {
           // $rootScope.notes = data.response;
           if(typeof callback != "undefined") {
             callback(notebookId, noteId, toNotebookId);
           }
         }
       });
     };

     paperworkNotesServiceFactory.getNotesInNotebook = function(notebookId, callback) {
       netService.apiGet('/notebooks/' + notebookId + '/notes', function(status, data) {
         if(status == 200) {
           $rootScope.notes = data.response;
           if(typeof callback != "undefined") {
             callback();
           }
         }
       });
     };

     paperworkNotesServiceFactory.getNotesInTag = function(tagId) {
       netService.apiGet('/tagged/' + tagId, function(status, data) {
         if(status == 200) {
           $rootScope.notes = data.response;
         }
       });
     };

     paperworkNotesServiceFactory.getNoteById = function(noteId, callback) {
       netService.apiGet('/notebooks/0/notes/' + noteId, function(status, data) {
         if(status == 200) {
           $rootScope.note = data.response;
           if(typeof callback != "undefined") {
             callback(data.response);
           }
         }
       });
     };

     paperworkNotesServiceFactory.getNotesFromSearch = function(query) {
       netService.apiGet('/search/' + base64.encode(query), function(status, data) {
         if(status == 200) {
           $rootScope.notes = data.response;
         }
       });
     };

     paperworkNotesServiceFactory.getNoteVersionAttachments = function(notebookId, noteId, versionId, callback) {
       netService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments', function(status, data) {
         if(status == 200) {
           if(typeof callback != "undefined") {
             callback(data.response);
           }
         }
       });
     };

     paperworkNotesServiceFactory.deleteNoteVersionAttachment = function(notebookId, noteId, versionId, attachmentId, callback) {
       netService.apiDelete('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments/' + attachmentId, callback);
     };

     return paperworkNotesServiceFactory;
   }]);
