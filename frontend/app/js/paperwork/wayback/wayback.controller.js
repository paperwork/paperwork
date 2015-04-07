angular.module('paperworkNotes').controller('WaybackController',
  function($scope, $rootScope, $location, $routeParams, NetService, NotesService) {
    // FIXME
    $('#paperworkViewParent').off('picked.freqselector').on('picked.freqselector', function(e) {
      var itemId = $(e.item).data('itemid');

      NetService.apiGet('/notebooks/' + $rootScope.getNotebookSelectedId() + '/notes/' + ($rootScope.getNoteSelectedId(true)).noteId + '/versions/' + itemId,
        function(status, data) {
          if(status == 200) {
            $rootScope.note.version.title = data.response.title;
            $rootScope.note.version.content = data.response.content;
            if(data.response.next_id === null) {
              itemId = 0;
            }
            $rootScope.note.version_id = itemId;
          }
        });

      NotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId, itemId, function(response) {
        $rootScope.fileList = response;
      });

    });
  });
