angular.module('paperworkNotes').factory('VersionsService',
  ['$rootScope', '$http', 'NetService',
   function($rootScope, $http, NetService) {
     var paperworkVersionsServiceFactory = {};

     paperworkVersionsServiceFactory.getVersionById = function(notebookId, noteId, versionId) {
       paperworkNetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId, function(status, data) {
         if(status == 200) {
           $rootScope.version = data.response;
         }
       });
     };

     paperworkVersionsServiceFactory.getVersionAttachments = function(notebookId, noteId, versionId, callback) {
       paperworkNetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments', function(status, data) {
         if(status == 200) {
           if(typeof callback != "undefined") {
             callback(data.response);
           }
         }
       });
     };

     return paperworkVersionsServiceFactory;
   }]);
