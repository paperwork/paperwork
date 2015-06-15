angular.module('paperworkNotes').controller('SidebarNotesController',
  function($scope, $rootScope, $location, $timeout, $routeParams, NotebooksService, NotesService, ngDraggable, StatusNotifications, NetService) {
    $scope.isVisible = function() {
      return !$rootScope.expandedNoteLayout;
    };

    $rootScope.getNoteSelectedId = function(asObject) {
      if(asObject === true) {
        return $rootScope.noteSelectedId;
      }
      return $rootScope.noteSelectedId.notebookId + "-" + $rootScope.noteSelectedId.noteId;
    };

    $rootScope.setNoteSelectedId = function(notebookId, noteId) {
      $rootScope.noteSelectedId.notebookId = notebookId;
      $rootScope.noteSelectedId.noteId = noteId;
    };

    $rootScope.getNoteByIdLocal = function(noteId) {
      var i = 0, l = $rootScope.notes.length;
      for(i = 0; i < l; i++) {
        if($rootScope.notes[i].id == noteId) {
          return $rootScope.notes[i];
        }
      }
      return null;
    };
    
    $scope.getUsers = function (noteId, callback){
      $scope.can_share=false;
        if(typeof $rootScope.i18n != "undefined")
	    $rootScope.umasks=[{'name':$rootScope.i18n.keywords.not_shared, 'value':0},
		   {'name':$rootScope.i18n.keywords.read_only, 'value':4},
		   {'name':$rootScope.i18n.keywords.read_write, 'value':6}];
	NetService.apiGet('/users/'+noteId, function(status, data) {
        if(status == 200) {
          $rootScope.users = data.response;
          angular.forEach(data.response,function(user,key){
            if (user['is_current_user'] && user['owner']) {
              $scope.can_share=true;
            }
            });
          callback(noteId);
        }
      });
    };
    $scope.newNote = function(notebookId) {
      if($rootScope.menuItemNotebookClass() === 'disabled') {
        return false;
      }
      
      var data = {
        'title':           $rootScope.i18n.keywords.untitled || 'Untitled',
        'content':         '',
        'content_preview': ''
      };
      
      var callback = (function(_notebookId) {
        return function(status, data) {
          console.log(status);
          switch(status) {
            case 200:
              $rootScope.templateNoteEdit = {};
              $location.path("/n/" + _notebookId + "/" + data.response.id + "/edit");
              StatusNotifications.sendStatusFeedback("success", "note_created_successfully");
              break;
            case 400:
              StatusNotifications.sendStatusFeedback("error", "note_create_fail");
              break;
            default:
              StatusNotifications.sendStatusFeedback("error", "note_create_fail");
              break;
          }
        };
      })(notebookId);
      
      if(typeof notebookId == "undefined" || notebookId == 0 || notebookId === "00000000-0000-0000-0000-000000000000") {
        //Open Select Notebook dialog to choose destination of new note 
        $rootScope.modalNotebookSelect({ 
            'notebookId': notebookId,
            'noteId': 0,
            'theCallback': function(notebookId, noteId, toNotebookId) {
                $('#modalNotebookSelect').modal('hide');
                NotesService.createNote(toNotebookId, data, callback);
            }
        });
      }else{
        NotesService.createNote(notebookId, data, callback);
      }
    };

    $scope.editNote = function(notebookId, noteId) {
      if($rootScope.menuItemNoteClass('single') === 'disabled') {
        return false;
      }
      $location.path("/n/" + notebookId + "/" + noteId + "/edit");
    };

    $scope.editNotes = function(notebookId, noteId) {
      if($rootScope.menuItemNoteClass('multiple') === 'disabled') {
        return false;
      }

      if($rootScope.editMultipleNotes == true) {
        $rootScope.editMultipleNotes = false;
      } else {
        $rootScope.editMultipleNotes = true;
      }
    };

    $scope.updateNote = function() {
      // if(typeof $rootScope.templateNoteEdit == "undefined" || $rootScope.templateNoteEdit == null) {
      //   $rootScope.templateNoteEdit = {};
      // }

      $rootScope.templateNoteEdit.version.content = CKEDITOR.instances.content.getData();

      var data = {
        'title':   $rootScope.templateNoteEdit.version.title,
        'content': $rootScope.templateNoteEdit.version.content,
        'tags':    $('input#tags').tagsinput('items')
      };

      var callback = (function() {
        return function(status, data) {
          switch(status) {
            case 200:
              $rootScope.errors = {};
              $rootScope.templateNoteEdit.modified = false;
              CKEDITOR.instances.content.resetDirty();
              // Temporary until related issue is closed
              StatusNotifications.sendStatusFeedback("success", "note_saved_successfully");
              break;
            case 400:
              $rootScope.errors = data.errors;
              $rootScope.messageBox({
                'title':   $rootScope.i18n.messages.error_message,
                'content': data.errors,
                'buttons': [
                  {
                    // We don't need an id for the dismiss button.
                    // 'id': 'button-no',
                    'label':     $rootScope.i18n.keywords.damn,
                    'isDismiss': true
                  }
                ]
              });
              break;
            default:
              StatusNotifications.sendStatusFeedback("error", "note_save_failed");
              break;
          }
        };
      })();

      NotesService.updateNote($rootScope.note.id, data, callback);
    };

    $scope.closeNote = function() {
      var closeNoteCallback = function() {
        var currentNote = $rootScope.getNoteSelectedId(true);
        $location.path("/n/" + $rootScope.getNotebookSelectedId() + "/" + currentNote.noteId);
        CKEDITOR.instances.content.destroy();
        $rootScope.templateNoteEdit = {};
        NotebooksService.getTags();
        return true;
      };

      if($rootScope.templateNoteEdit && $rootScope.templateNoteEdit.modified) {
        $rootScope.messageBox({
          'title':   $rootScope.i18n.keywords.close_without_saving_question,
          'content': $rootScope.i18n.keywords.close_without_saving_message,
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
                return closeNoteCallback();
              }
            }
          ]
        });
      } else {
        return closeNoteCallback();
      }
    };

    $scope.modalDeleteNote = function(notebookId, noteId) {
      if($rootScope.menuItemNoteClass('multiple') === 'disabled') {
        return false;
      }
      var callback = (function() {
        return function(status, data) {
          switch(status) {
            case 200:
              $location.path("/n/" + notebookId);
              break;
            case 400:
              // TODO: Show some kind of error
              break;
          }
        };
      })();

      $rootScope.messageBox({
        'title':   ($rootScope.editMultipleNotes ? $rootScope.i18n.keywords.delete_notes_question : $rootScope.i18n.keywords.delete_note_question),
        'content': ($rootScope.editMultipleNotes ? $rootScope.i18n.keywords.delete_notes_message : $rootScope.i18n.keywords.delete_note_message),
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
              if($rootScope.editMultipleNotes) {
                noteId = [];
                angular.forEach($rootScope.notesSelectedIds, function(isChecked, checkedNoteId) {
                  if(isChecked) {
                    noteId.push(checkedNoteId);
                  }
                });
              }
              NotesService.deleteNote(noteId, callback, function() {
                $location.path("/n/" + notebookId);
              });
              return true;
            }
          }
        ]
      });
    };

    $scope.modalMoveNote = function(notebookId, noteId) {

      if($rootScope.menuItemNoteClass('multiple') === 'disabled') {
        return false;
      }

      $rootScope.modalNotebookSelect({
        'notebookId':  notebookId,
        'noteId':      noteId,
        'theCallback': function(notebookId, noteId, toNotebookId) {
          if($rootScope.editMultipleNotes) {
            noteId = [];
            angular.forEach($rootScope.notesSelectedIds, function(isChecked, checkedNoteId) {
              if(isChecked) {
                noteId.push(checkedNoteId);
              }
            });
          }
          NotesService.moveNote(notebookId, noteId, toNotebookId, function(_notebookId, _noteId, _toNotebookId) {
            $('#modalNotebookSelect').modal('hide');
            $location.path("/n/" + (_toNotebookId));
          });
          return true;
        },
        'header':      $rootScope.i18n.keywords.select_notebook_title,
        'description': $rootScope.i18n.notebooks.move_note_description
      });
    };

    $scope.modalShareNote = function(notebookId,noteId){
      if($rootScope.menuItemNoteClass('multiple') === 'disabled') {
        return false;
      }
      $scope.getUsers(noteId,function(noteId){
        if (!$scope.can_share) {
          $rootScope.messageBox({
        'title':   $rootScope.i18n.keywords.cannot_share_title,
        'content':  $rootScope.i18n.keywords.cannot_share_message,
        'buttons': [
          {
            // We don't need an id for the dismiss button.
            // 'id': 'button-no',
            'label':     $rootScope.i18n.keywords.close,
            'isDismiss': true
          }]});
          return false;
        }
        console.log(noteId);
        $rootScope.modalUsersSelect({
          'notebookId': notebookId,
          'noteId': noteId,
          'theCallback':function(notebookId,noteId,toUsers){
            if ($rootScope.editMultipleNotes) {
              noteId=[];
              console.log($rootScope.notesSelectedIds);
              angular.forEach($rootScope.notesSelectedIds, function(isChecked, checkedNoteId) {
                console.log(checkedNoteId);
                if(isChecked) {
                  noteId.push(checkedNoteId);
                }
              });
            }
            toUserId=[]
            toUMASK=[]
            angular.forEach(toUsers, function(user,key){
                if (!user['is_current_user']) {
                  toUserId.push(user['id']);
                  toUMASK.push(user['umask']);
                }
              });
            NotesService.shareNote(notebookId,noteId,toUserId, toUMASK, function(_notebookId,_noteId){
              $('#modalUsersSelect').modal('hide');
              $location.path("/n/"+(_notebookId));
            });
            return true;
          }
        });
      });
    };
    
    $scope.modalUsersSelectSubmit = function(notebookId, noteId, toUserId) {
      console.log(toUserId);
      $rootScope.modalMessageBox.theCallback(notebookId, noteId, toUserId);
    };
    
    $scope.modalUsersSelectInherit = function(notebookId){
      NetService.apiGet('/users/notebooks/'+notebookId, function(status, data) {
        if(status == 200) {
          $rootScope.users = data.response;
        }
      });
    }
    $scope.submitSearch = function() {
      if($scope.search == "") {
        $location.path("/");
      } else {
        $location.path("/s/" + encodeURIComponent($scope.search));
      }
    };

    $scope.onDragSuccess = function(data, event) {
      //u
    };

    $scope.openShare = function(){
      $rootScope.messageBox({
          'title': $rootScope.i18n.keywords.coming_soon,
          'content': $rootScope.i18n.keywords.not_implemented,
          'buttons': [
            {
              'class': 'btn-primary',
              'label': $rootScope.i18n.keywords.close,
              'isDismiss': true
            }
          ]
      });
    };

  });
