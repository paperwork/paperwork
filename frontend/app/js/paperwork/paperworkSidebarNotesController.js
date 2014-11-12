paperworkModule.controller('paperworkSidebarNotesController', function($scope, $rootScope, $location, $timeout, $routeParams, paperworkNotebooksService, paperworkNotesService){
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
  }

  $rootScope.getNoteByIdLocal = function(noteId) {
    var i=0, l=$rootScope.notes.length;
    for(i=0; i<l; i++) {
      if($rootScope.notes[i].id == noteId) {
        return $rootScope.notes[i];
      }
    }
    return null;
  }

  $scope.newNote = function(notebookId) {
    if(typeof notebookId == "undefined" || notebookId == 0) {
      // TODO: Show some error
    }

    var data = {
      'title': $rootScope.i18n.keywords.untitled,
      'content': ''
    };

    var callback = (function(_notebookId) {
      return function(status, data) {
        switch(status) {
          case 200:
            $rootScope.templateNoteEdit = {};
            $location.path("/n/" + _notebookId + "/" + data.response.id + "/edit");
            break;
          case 400:
            // TODO: Show some kind of error
            break;
        }
      };
    })(notebookId);

    paperworkNotesService.createNote(notebookId, data, callback);
  };

  $scope.editNote = function (notebookId, noteId) {
    $location.path("/n/" + notebookId + "/" + noteId + "/edit");
  };

  $scope.editNotes = function (notebookId, noteId) {
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

    $rootScope.templateNoteEdit.content = CKEDITOR.instances.content.getData();

    var data = {
      'title': $rootScope.templateNoteEdit.title,
      'content': $rootScope.templateNoteEdit.content,
      'tags': $('input#tags').tagsinput('items')
    };

    var callback = (function() {
      return function(status, data) {
        switch(status) {
          case 200:
            $rootScope.errors = {};
            $rootScope.templateNoteEdit.modified = false;
            // TODO: Show cool success message
            break;
          case 400:
            $rootScope.errors = data.errors;
            $rootScope.messageBox({
              'title': $rootScope.i18n.messages.error_message,
              'content': data.errors,
              'buttons': [
                {
                  // We don't need an id for the dismiss button.
                  // 'id': 'button-no',
                  'label': $rootScope.i18n.keywords.damn,
                  'isDismiss': true
                }
              ]
            });
            break;
        }
      };
    })();

    paperworkNotesService.updateNote($rootScope.note.id, data, callback);
  };

  $scope.closeNote = function() {
    var closeNoteCallback = function() {
      var currentNote = $rootScope.getNoteSelectedId(true);
      $location.path("/n/" + $rootScope.getNotebookSelectedId() + "/" + currentNote.noteId);
      CKEDITOR.instances.content.destroy();
      $rootScope.templateNoteEdit = {};
      paperworkNotebooksService.getTags();
      return true;
    }

    if($rootScope.templateNoteEdit && $rootScope.templateNoteEdit.modified) {
      $rootScope.messageBox({
        'title': $rootScope.i18n.keywords.close_without_saving_question,
        'content': $rootScope.i18n.keywords.close_without_saving_message,
        'buttons': [
          {
            // We don't need an id for the dismiss button.
            // 'id': 'button-no',
            'label': $rootScope.i18n.keywords.cancel,
            'isDismiss': true
          },
          {
            'id': 'button-yes',
            'label': $rootScope.i18n.keywords.yes,
            'class': 'btn-warning',
            'click': function() {
              return closeNoteCallback();
            },
          }
        ]
      });
    } else {
      return closeNoteCallback();
    }
  };

  $scope.modalDeleteNote = function(notebookId, noteId) {
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
      'title': ($rootScope.editMultipleNotes ? $rootScope.i18n.keywords.delete_notes_question : $rootScope.i18n.keywords.delete_note_question),
      'content': ($rootScope.editMultipleNotes ? $rootScope.i18n.keywords.delete_notes_message : $rootScope.i18n.keywords.delete_note_message),
      'buttons': [
        {
          // We don't need an id for the dismiss button.
          // 'id': 'button-no',
          'label': $rootScope.i18n.keywords.cancel,
          'isDismiss': true
        },
        {
          'id': 'button-yes',
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
            paperworkNotesService.deleteNote(noteId, callback, function() {
              $location.path("/n/" + notebookId);
            });
            return true;
          },
        }
      ]
    });
  };

  $scope.modalMoveNote = function(notebookId, noteId) {
    $rootScope.modalNotebookSelect({
      'notebookId': notebookId,
      'noteId': noteId,
      'theCallback': function(notebookId, noteId, toNotebookId) {
        if($rootScope.editMultipleNotes) {
          noteId = [];
          angular.forEach($rootScope.notesSelectedIds, function(isChecked, checkedNoteId) {
            if(isChecked) {
              noteId.push(checkedNoteId);
            }
          });
        }
        paperworkNotesService.moveNote(notebookId, noteId, toNotebookId, function(_notebookId, _noteId, _toNotebookId) {
          $('#modalNotebookSelect').modal('hide');
          $location.path("/n/" + parseInt(_toNotebookId));
        });
        return true;
      }
    });
  };

  $scope.submitSearch = function() {
    if($scope.search == "") {
      $location.path("/");
    } else {
      $location.path("/s/" + encodeURIComponent($scope.search));
    }
  };
});