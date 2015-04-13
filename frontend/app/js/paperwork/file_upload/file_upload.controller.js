angular.module('paperworkNotes').controller('FileUploadController',
  function($scope, $rootScope, $location, $routeParams, FileUploader, NotesService, StatusNotifications) {
    var uploader = $scope.uploader = new FileUploader({
      url: $rootScope.uploadUrl
    });

    uploader.filters.push({
      name: 'customFilter',
      fn:   function(item /*{File|FileLikeObject}*/, options) {
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
      StatusNotifications.sendStatusFeedback("error", "upload_failed");
    };
    uploader.onCancelItem = function(fileItem, response, status, headers) {
      // console.info('onCancelItem', fileItem, response, status, headers);
    };
    uploader.onCompleteItem = function(fileItem, response, status, headers) {
      // console.info('onCompleteItem', fileItem, response, status, headers);
    };
    uploader.onCompleteAll = function() {
      // console.info('onCompleteAll');
      NotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId,
        $rootScope.getVersionSelectedId(true).versionId, function(response) {
          $rootScope.fileList = response;
          uploader.clearQueue();
        });
      StatusNotifications.sendStatusFeedback("success", "file_uploaded_sucessfully");
    };

    $('#file-upload-dropzone').click(function() {
      $('#file-upload-input').click();
    });

    $scope.fileUploadDeleteFile = function(notebookId, noteId, versionId, attachmentId, isSure) {
      if(isSure != true) {
        $rootScope.messageBox({
          'title':   $rootScope.i18n.keywords.delete_attachment_question,
          'content': $rootScope.i18n.keywords.delete_attachment_message,
          'buttons': [
            {
              // We don't need an id for the dismiss button.
              // 'id': 'button-no',
              'label':     $rootScope.i18n.keywords.cancel,
              'isDismiss': true
            },
            {
              'id':    'button-yes',
              'label': $rootScope.i18n.keywords.yes,
              'class': 'btn-warning',
              'click': function() {
                return $scope.fileUploadDeleteFile(notebookId, noteId, versionId, attachmentId, true);
              }
            }
          ]
        });
      } else {
        NotesService.deleteNoteVersionAttachment(notebookId, noteId, versionId, attachmentId, function(response) {
          var fileUrl = '/api/v1/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments/' + attachmentId + '/raw';
          var i, l = $rootScope.fileList.length;
          for(i = 0; i < l; i++) {
            if(typeof $rootScope.fileList[i] != "undefined" && typeof $rootScope.fileList[i].id != "undefined" && $rootScope.fileList[i].id == attachmentId) {
              $rootScope.fileList.splice(i, 1);
            }
          }

          $rootScope.$broadcast('deleteAttachmentLink', {'url': fileUrl});
          StatusNotifications.sendStatusFeedback("success", "file_deleted_sucessfully");
        });
      }
      return true;
      // console.log("notebookId " + notebookId + ' noteId ' + noteId + ' versionId ' + versionId + ' attachmentId ' + attachmentId);
    };

    $scope.fileUploadInsertFile = function(notebookId, noteId, versionId, attachmentId, attachment) {
      var fileUrl = '/api/v1/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments/' + attachmentId + '/raw';
      $rootScope.$broadcast('insertAttachmentLink', {'url': fileUrl, 'filename': attachment.filename, 'mimetype': attachment.mimetype});
    };

    $scope.getFaClassFromMimetype = function(mimetype) {
      var mimematch = /(.+)\/(.+)/g.exec(mimetype);
      switch(mimematch[1]) {
        case 'image':
          return 'fa-file-image-o';
        case 'video':
          return 'fa-file-movie-o';
        case 'audio':
          return 'fa-file-audio-o';
        case 'application':
          switch(mimematch[2]) {
            case 'pdf':
              return 'fa-file-pdf-o';
            case 'zip':
              return 'fa-file-archive-o';
            default:
              return 'fa-file-o';
          }
          break;
        default:
          return 'fa-file-o';
      }
    };
  });
