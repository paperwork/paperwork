angular.module('paperworkNotes').controller('WaybackController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NetService', 'NotesService',
   function($scope, $rootScope, $location, $routeParams, netService, notesService) {
     // FIXME
     $('#paperworkViewParent').off('picked.freqselector').on('picked.freqselector', function(e) {
       var itemId = $(e.item).data('itemid');

       netService.apiGet('/notebooks/' + $rootScope.getNotebookSelectedId() + '/notes/' + ($rootScope.getNoteSelectedId(true)).noteId + '/versions/' + itemId,
         function(status, data) {
           if(status == 200) {
             $rootScope.note.title = data.response.title;
             $rootScope.note.content = data.response.content;
             if(data.response.next_id === null) {
               itemId = 0;
             }
             $rootScope.note.version = itemId;
           }
         });

       notesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId, itemId, function(response) {
         $rootScope.fileList = response;
       });

     });
   }]);
