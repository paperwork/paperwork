paperworkModule.controller('paperworkFileUploadController', ['$scope', '$rootScope', '$location', '$routeParams', 'FileUploader', 'paperworkNotesService', function($scope, $rootScope, $location, $routeParams, FileUploader, paperworkNotesService) {
  var uploader = $scope.uploader = new FileUploader({
    url: $rootScope.uploadUrl
  });

  uploader.filters.push({
    name: 'customFilter',
    fn: function(item /*{File|FileLikeObject}*/, options) {
        return this.queue.length < 10;
    }
  });

  uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
      // console.info('onWhenAddingFileFailed', item, filter, options);
  };
  uploader.onAfterAddingFile = function(fileItem) {
      // console.info('onAfterAddingFile', fileItem);
  };
  uploader.onAfterAddingAll = function(addedFileItems) {
      // console.info('onAfterAddingAll', addedFileItems);
  };
  uploader.onBeforeUploadItem = function(item) {
      // console.info('onBeforeUploadItem', item);
  };
  uploader.onProgressItem = function(fileItem, progress) {
      // console.info('onProgressItem', fileItem, progress);
  };
  uploader.onProgressAll = function(progress) {
      // console.info('onProgressAll', progress);
  };
  uploader.onSuccessItem = function(fileItem, response, status, headers) {
      // console.info('onSuccessItem', fileItem, response, status, headers);
  };
  uploader.onErrorItem = function(fileItem, response, status, headers) {
      // console.info('onErrorItem', fileItem, response, status, headers);
  };
  uploader.onCancelItem = function(fileItem, response, status, headers) {
      // console.info('onCancelItem', fileItem, response, status, headers);
  };
  uploader.onCompleteItem = function(fileItem, response, status, headers) {
      // console.info('onCompleteItem', fileItem, response, status, headers);
  };
  uploader.onCompleteAll = function() {
      // console.info('onCompleteAll');
      paperworkNotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId, $rootScope.getVersionSelectedId(true).versionId, function(response) {
        $rootScope.fileList = response;
        uploader.clearQueue();
      });
  };

  $scope.fileUploadDeleteFile = function(notebookId, noteId, versionId, attachmentId) {
    paperworkNotesService.deleteNoteVersionAttachment(notebookId, noteId, versionId, attachmentId, function(response) {
      var i, l = $rootScope.fileList.length;
      for(i=0; i<l; i++) {
        if(typeof $rootScope.fileList[i] != "undefined" && typeof $rootScope.fileList[i].id != "undefined" && $rootScope.fileList[i].id == attachmentId) {
          $rootScope.fileList.splice(i, 1);
        }
      }
    });
    // console.log("notebookId " + notebookId + ' noteId ' + noteId + ' versionId ' + versionId + ' attachmentId ' + attachmentId);
  };
}]);