var paperworkApi = '/api/v1';
angular.module("paperworkNotes", ['ngRoute', 'ngSanitize', 'ngAnimate', 'angularFileUpload'])
.config(function($routeProvider) {
  $routeProvider
  .when('/', {
    redirectTo:'/n/0'
  })
  .when('/n/:notebookId', {
    controller:'paperworkNotesAllController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/n/:notebookId/:noteId', {
    controller:'paperworkNotesShowController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/n/:notebookId/:noteId/edit', {
    controller:'paperworkNotesEditController',
    templateUrl:'templates/paperworkNoteEdit'
  })
  .when('/s/:searchQuery', {
    controller:'paperworkSearchController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/s/:searchQuery/n/:notebookId/:noteId', {
    controller:'paperworkNotesShowController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/404', {
    controller:'paperworkFourOhFourController',
    templateUrl:'templates/paperwork404'
  })
  .otherwise({
    redirectTo:'/404'
  });
}).service('paperworkNetService', ['$rootScope', '$http', function($rootScope, $http) {
  this.apiGet = function(url, callback) {
    $http({method: 'GET', url: paperworkApi + url}).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };

  this.apiPost = function(url, data, callback) {
    $http.post(paperworkApi + url, data).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };

  this.apiPut = function(url, data, callback) {
    $http.put(paperworkApi + url, data).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };

  this.apiDelete = function(url, callback) {
    $http.delete(paperworkApi + url).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };
}]).factory('paperworkNotebooksService', ['$rootScope', '$http', 'paperworkNetService', function($rootScope, $http, paperworkNetService) {
  var paperworkNotebooksServiceFactory = {};

  // paperworkNotebooksServiceFactory.selectedNotebookId = 0;

  paperworkNotebooksServiceFactory.createNotebook = function(data, callback) {
    paperworkNetService.apiPost('/notebooks', data, callback);
  };

  paperworkNotebooksServiceFactory.updateNotebook = function(notebookId, data, callback) {
    paperworkNetService.apiPut('/notebooks/' + notebookId, data, callback);
  };

  paperworkNotebooksServiceFactory.deleteNotebook = function(notebookId, callback) {
    paperworkNetService.apiDelete('/notebooks/' + notebookId, callback);
  };

  paperworkNotebooksServiceFactory.getNotebooks = function() {
    paperworkNetService.apiGet('/notebooks', function(status, data) {
      if(status == 200) {
        $rootScope.notebooks = data.response;
      }
    });
  };

  paperworkNotebooksServiceFactory.getNotebookById = function(notebookId) {
    paperworkNetService.apiGet('/notebooks/' + notebookId, function(status, data) {
      if(status == 200) {
        $rootScope.notebook = data.response;
      }
    });
  };

  paperworkNotebooksServiceFactory.getNotebookByIdLocal = function(notebookId) {
    var i=0, l=$rootScope.notebooks.length;
    for(i=0; i<l; i++) {
      if($rootScope.notebooks[i].id == notebookId) {
        return $rootScope.notebooks[i];
      }
    }
    return null;
  }

  paperworkNotebooksServiceFactory.getNotebookShortcuts = function() {
    paperworkNetService.apiGet('/shortcuts', function(status, data) {
      if(status == 200) {
        $rootScope.shortcuts = data.response;
      }
    });
  }

  paperworkNotebooksServiceFactory.getShortcutByNotebookIdLocal = function(notebookId) {
    var i=0, l=$rootScope.shortcuts.length;
    for(i=0; i<l; i++) {
      if($rootScope.shortcuts[i].id == notebookId) {
        return $rootScope.shortcuts[i];
      }
    }
    return null;
  }

  paperworkNotebooksServiceFactory.getTags = function() {
    paperworkNetService.apiGet('/tags', function(status, data) {
      if(status == 200) {
        $rootScope.tags = data.response;
      }
    });
  };

  return paperworkNotebooksServiceFactory;
}]).factory('paperworkNotesService', ['$rootScope', '$http', 'paperworkNetService', function($rootScope, $http, paperworkNetService) {
  var paperworkNotesServiceFactory = {};

  // paperworkNotesServiceFactory.selectedNoteIndex = 0;

  paperworkNotesServiceFactory.createNote = function(notebookId, data, callback) {
    paperworkNetService.apiPost('/notebooks/' + notebookId + '/notes', data, callback);
  };

  paperworkNotesServiceFactory.updateNote = function(noteId, data, callback) {
    paperworkNetService.apiPut('/notebooks/0/notes/' + noteId, data, callback);
  };

  paperworkNotesServiceFactory.deleteNote = function(noteId, callback) {
    paperworkNetService.apiDelete('/notebooks/0/notes/' + noteId, callback);
  };

  paperworkNotesServiceFactory.getNotesInNotebook = function(notebookId, callback) {
    paperworkNetService.apiGet('/notebooks/' + notebookId + '/notes', function(status, data) {
      if(status == 200) {
        $rootScope.notes = data.response;
        if(typeof callback != "undefined") {
          callback();
        }
      }
    });
  };

  paperworkNotesServiceFactory.getNotesInTag = function(tagId) {
    paperworkNetService.apiGet('/tagged/' + tagId, function(status, data) {
      if(status == 200) {
        $rootScope.notes = data.response;
      }
    });
  };

  paperworkNotesServiceFactory.getNoteById = function(noteId) {
    paperworkNetService.apiGet('/notebooks/0/notes/' + noteId, function(status, data) {
      if(status == 200) {
        $rootScope.note = data.response;
      }
    });
  };

  paperworkNotesServiceFactory.getNoteVersionAttachments = function(notebookId, noteId, versionId, callback) {
    paperworkNetService.apiGet('/notebooks/' + notebookId + '/notes/' + noteId + '/versions/' + versionId + '/attachments', function(status, data) {
      if(status == 200) {
        if(typeof callback != "undefined") {
          callback(data.response);
        }
      }
    });
  };

  return paperworkNotesServiceFactory;
}]).factory('paperworkMessageBoxService', ['$rootScope', '$http', 'paperworkNetService', function($rootScope, $http, paperworkNetService) {
  var paperworkMessageBoxFactory = {};



  return paperworkMessageBoxFactory;
}]).controller('paperworkConstructorController', function($scope, $rootScope, $location, $routeParams, paperworkNetService) {
    if($rootScope.initDone) {
      return;
    }
    $rootScope.initDone = true;

    // if(typeof $rootScope.versionSelectedId == "undefined") {
    //   console.log($rootScope.getNoteSelectedId());
    // }

    paperworkNetService.apiGet('/i18n', function(status, data) {
      if(status == 200) {
        $rootScope.i18n = data.response;
      }
    });

    $rootScope.modal = {
      'active': false,
      'next': []
    };

    $rootScope.$on('paperworkModalVisible', function(ev, data) {
      $rootScope.modal.active = true;
    });

    $rootScope.$on('paperworkModalHidden', function(ev, data) {
      $rootScope.modal.active = false;

      if($rootScope.modal.next.length > 0) {
        if($rootScope.modal.next[0].callback) {
          $rootScope.modal.next[0].callback();
        }
        $rootScope.modal.next.splice(0,1);
      }
    });

    $('#modalNotebook').on('hidden.bs.modal', function (e) {
      $(this).find('input[name="title"]').parents('.form-group').removeClass('has-warning');
    });

    $('.modal').on('hidden.bs.modal', function(e) {
      $rootScope.$broadcast('paperworkModalHidden', e);
    });

    $('.modal').on('show.bs.modal', function(e) {
      $rootScope.$broadcast('paperworkModalVisible', e);
    });

    $rootScope.getVersionSelectedId = function(asObject) {
      if(asObject === true) {
        return $rootScope.versionSelectedId;
      }
      return $rootScope.versionSelectedId.notebookId + "-" + $rootScope.versionSelectedId.noteId + "-" + $rootScope.versionSelectedId.versionId;
    };


    $rootScope.messageBox = function(messageBoxData) {
      var callback = function(data) {
        $rootScope.modalMessageBox = data;
        $('#modalMessageBox').modal('show');
      };
      if($rootScope.modal.active === false) {
        callback(messageBoxData);
      } else {
        $rootScope.modal.next.push({
          'id': 'modalMessageBox',
          'callback': function() {
            callback(messageBoxData);
          }
        });
      }
    };
}).controller('paperworkDefaultController', function($scope, $location, $routeParams, paperworkNotesService) {
}).controller('paperworkNotesAllController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
    if(typeof $routeParams == "undefined" || $routeParams == {} || typeof $routeParams.notebookId == "undefined") {
      return;
      $rootScope.notebookSelectedId = 0;
    } else {
      $rootScope.notebookSelectedId = parseInt($routeParams.notebookId);
    }
    paperworkNotesService.getNotesInNotebook($rootScope.notebookSelectedId);
    $rootScope.navbarMainMenu = true;
    $rootScope.navbarSearchForm = true;

    // $rootScope.note = null; // TODO: Do we still need this?

    // $location.path("/notebook/" + $scope.notebookSelectedId + "/note/" + $rootScope.notes[0].id);
}).controller('paperworkNotesShowController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
  if(!angular.isNumber(parseInt($routeParams.noteId)) || $routeParams.noteId === "undefined") {
    return;
  }
  $rootScope.noteSelectedId = { 'notebookId': parseInt($routeParams.notebookId), 'noteId': parseInt($routeParams.noteId) };
  $rootScope.versionSelectedId = { 'notebookId': parseInt($routeParams.notebookId), 'noteId': parseInt($routeParams.noteId), 'versionId': 0 };

  if(typeof $routeParams.searchQuery == "undefined" || $routeParams.searchQuery == null || $routeParams.searchQuery.length <= 0) {
    paperworkNotesService.getNotesInNotebook(parseInt($routeParams.notebookId));
    $rootScope.notebookSelectedId = parseInt($routeParams.notebookId);
  }

  paperworkNotesService.getNoteById(parseInt($routeParams.noteId));

  paperworkNotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), $rootScope.getNoteSelectedId(), $rootScope.getVersionSelectedId(true).versionId, function(response) {
    $rootScope.fileList = response;
  });

  $rootScope.navbarMainMenu = true;
  $rootScope.navbarSearchForm = true;
  $rootScope.expandedNoteLayout = false;
}).controller('paperworkNotesEditController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
  var thisController = function(notebookId, noteId) {
    $rootScope.noteSelectedId = { 'notebookId': notebookId, 'noteId': noteId };
    $rootScope.versionSelectedId = { 'notebookId': notebookId, 'noteId': noteId, 'versionId': 0 };
    paperworkNotesService.getNoteById(noteId);
    $rootScope.templateNoteEdit = $rootScope.getNoteByIdLocal(noteId);

    paperworkNotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), $rootScope.getNoteSelectedId(), $rootScope.getVersionSelectedId(true).versionId, function(response) {
      $rootScope.fileList = response;
      console.log($rootScope.fileList);
    });

    var ck =  CKEDITOR.replace('content', {
      fullPage: false,
      // extraPlugins: 'myplugin,anotherplugin',
      removePlugins: 'sourcearea,save,newpage,preview,print,forms'
    });

    ck.on('change', function() {
      // Let's access our $rootScope from within jQuery (this)
      _$scope = $('body').scope();
      _$rootScope = _$scope.$root;
      _$scope.$apply(function() {
        _$rootScope.templateNoteEdit.modified = true;
      });
    });
  }

  $rootScope.uploadUrl = paperworkApi + '/notebooks/' + parseInt($routeParams.notebookId) + '/notes/' + parseInt($routeParams.noteId) + '/versions/0/attachments';

  if(typeof $rootScope.notes == "undefined") {
    paperworkNotesService.getNotesInNotebook($rootScope.notebookSelectedId, (function(_notebookId, _noteId) {
      return function() {
        thisController(_notebookId, _noteId);
      }
    })(parseInt($routeParams.notebookId), parseInt($routeParams.noteId)) );
  } else {
    thisController(parseInt($routeParams.notebookId), parseInt($routeParams.noteId));
  }

  $rootScope.navbarMainMenu = false;
  $rootScope.navbarSearchForm = false;
  $rootScope.expandedNoteLayout = true;
}).controller('paperworkNotesListController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
    $rootScope.noteSelectedId = {};
    paperworkNotesService.getNotesInNotebook(0);

    $scope.noteSelect = function($notebookId, $noteId) {
      $rootScope.noteSelectedId = { 'notebookId': parseInt($notebookId), 'noteId': parseInt($noteId) };
    }

    $scope.getNoteLink = function(notebookId, noteId) {

      var path = "/n/" + parseInt(notebookId) + "/" + parseInt(noteId);
      if($location.$$path.match(/^\/s\//i) != null) {
        var basePath = $location.$$path.match(/(^\/s\/[^\/]*)/i);
        return basePath[1] + path;
      }
      return path;
    };

}).controller('paperworkSidebarNotebooksController', function($scope, $rootScope, $location, $routeParams, paperworkNotebooksService){
  $rootScope.notebookSelectedId = 0;
  $rootScope.tagsSelectedId = -1;

  $scope.isVisible = function() {
    return !$rootScope.expandedNoteLayout;
  };

  $scope.notebookIconByType = function(type) {
    switch(parseInt(type)) {
      case 0:
        return 'fa-book';
      break;
      case 1:
        return 'fa-folder-open';
      break;
      case 2:
        return 'fa-archive';
      break;
    }
  };

  $rootScope.getNotebookSelectedId = function() {
    return $rootScope.notebookSelectedId;
  };

  $scope.openNotebook = function(notebookId, type, index) {
    if(parseInt(type) == 0 || parseInt(type) == 2) {
      $rootScope.notebookSelectedId = parseInt(index);
      $rootScope.tagsSelectedId = -1;
      $rootScope.search = "";
      $location.path("/n/" + parseInt(notebookId) );
    }
  };

  $scope.openTag = function(tagId) {
    $rootScope.notebookSelectedId = -1;
    $rootScope.tagsSelectedId = parseInt(tagId);
    $location.path("/s/tagid:" + parseInt(tagId));
  };

  $scope.modalNewNotebook = function() {
    $rootScope.modalNotebook = {
      'action': 'create',
      'shortcut': '',
      'title': ''
    };
    $('#modalNotebook').modal("show");
  };

  $scope.modalNotebookSubmit = function() {
    var data = {
      'type': 0,
      'title': $rootScope.modalNotebook.title,
      'shortcut': $rootScope.modalNotebook.shortcut
    };

    var callback = (function(_paperworkNotebooksService) {
      return function(status, data) {
        switch(status) {
          case 200:
            $('#modalNotebook').modal('hide');
            _paperworkNotebooksService.getNotebooks();
            _paperworkNotebooksService.getNotebookShortcuts(null);
            break;
          case 400:
            if(typeof data.errors.title != "undefined") {
              $('#modalNotebook').find('input[name="title"]').parents('.form-group').addClass('has-warning');
            }
            break;
        }
      };
    })(paperworkNotebooksService);

    if($rootScope.modalNotebook.action == "create") {
      paperworkNotebooksService.createNotebook(data, callback);
    } else if($rootScope.modalNotebook.action == "edit") {
      // if($rootScope.modalNotebook.delete) {
        // paperworkNotebooksService.deleteNotebook($rootScope.modalNotebook.id, callback);
      // } else {
        paperworkNotebooksService.updateNotebook($rootScope.modalNotebook.id, data, callback);
      // }
    }
  };

  $scope.modalEditNotebook = function(notebookId) {
    var notebook = paperworkNotebooksService.getNotebookByIdLocal(notebookId);

    if(notebook == null) {
      return false;
    }

    $rootScope.modalNotebook = {
      'action': 'edit',
      'id': notebookId,
      'title': notebook.title
    };

    var shortcut = paperworkNotebooksService.getShortcutByNotebookIdLocal(notebookId);

    if(shortcut == null) {
      $rootScope.modalNotebook.shortcut = false;
    } else {
      $rootScope.modalNotebook.shortcut = true;
    }
    $('#modalNotebook').modal("show");
  };

  $scope.modalDeleteNotebook = function(notebookId) {
    var callback = (function() {
      return function(status, data) {
        switch(status) {
          case 200:
            paperworkNotebooksService.getNotebookShortcuts(null);
            paperworkNotebooksService.getNotebooks();
            $location.path("/n/0");
            break;
          case 400:
            // TODO: Show some kind of error
            break;
        }
      };
    })();


    $rootScope.messageBox({
      'title': $rootScope.i18n.keywords.delete_notebook_question,
      'content': $rootScope.i18n.keywords.delete_notebook_message,
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
            paperworkNotebooksService.deleteNotebook(notebookId, callback);
            return true;
          },
        }
      ]
    });
  };

  paperworkNotebooksService.getNotebookShortcuts(null);
  paperworkNotebooksService.getNotebooks();
  $rootScope.tags = paperworkNotebooksService.getTags();
}).controller('paperworkSidebarNotesController', function($scope, $rootScope, $location, $timeout, $routeParams, paperworkNotesService){

  $scope.isVisible = function() {
    return !$rootScope.expandedNoteLayout;
  };

  $rootScope.getNoteSelectedId = function(asObject) {
    if(asObject === true) {
      return $rootScope.noteSelectedId;
    }
    return $rootScope.noteSelectedId.notebookId + "-" + $rootScope.noteSelectedId.noteId;
  };

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
      'title': '',
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

  $scope.updateNote = function() {
    $rootScope.templateNoteEdit.content = CKEDITOR.instances.content.getData();

    var data = {
      'title': $rootScope.templateNoteEdit.title,
      'content': $rootScope.templateNoteEdit.content
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
            // TODO: Show some kind of error
            break;
        }
      };
    })();

    paperworkNotesService.updateNote($rootScope.note.id, data, callback);
  };

  $scope.closeNote = function() {
    if($rootScope.templateNoteEdit && $rootScope.templateNoteEdit.modified) {
      // TODO: Ask!
    }
    var currentNote = $rootScope.getNoteSelectedId(true);
    $location.path("/n/" + $rootScope.getNotebookSelectedId() + "/" + currentNote.noteId);
    CKEDITOR.instances.content.destroy();
    $rootScope.templateNoteEdit = {};
  };

  // *** NOT IN USE ***
  // $scope.deleteNote = function() {
  //   if(typeof $rootScope.templateNoteEdit == "undefined" || $rootScope.templateNoteEdit == null) {
  //     $rootScope.templateNoteEdit = {
  //       'delete': 0
  //     };
  //   }
  //   if($rootScope.templateNoteEdit.delete == 1) {
  //     var callback = (function() {
  //       return function(status, data) {
  //         switch(status) {
  //           case 200:
  //             // TODO: Show cool success message
  //             $rootScope.templateNoteEdit.delete = 0;
  //             $location.path("/n/" + $rootScope.notebookSelectedId);
  //             break;
  //           case 400:
  //             // TODO: Show some kind of error
  //             break;
  //         }
  //       };
  //     })();
  //     paperworkNotesService.deleteNote($rootScope.note.id, callback);
  //   } else {
  //     $rootScope.templateNoteEdit.delete = 1;
  //     $timeout(function() {
  //       console.log($rootScope.templateNoteEdit.delete);
  //       $rootScope.templateNoteEdit.delete = 0;
  //     }, 3000)
  //   }
  // }

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
      'title': $rootScope.i18n.keywords.delete_note_question,
      'content': $rootScope.i18n.keywords.delete_note_message,
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
            paperworkNotesService.deleteNote(noteId, callback);
            return true;
          },
        }
      ]
    });
  };

  $scope.submitSearch = function() {
    if($scope.search == "") {
      $location.path("/");
    } else {
      $location.path("/s/" + encodeURIComponent($scope.search));
    }
  };
}).controller('paperworkVersionsController', function($scope, $rootScope, $location, $timeout, $routeParams){
  // TODO
}).controller('paperworkViewController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  $scope.isVisible = function() {
    return !$rootScope.expandedNoteLayout;
  }
}).controller('paperworkSearchController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  var sQ = $routeParams.searchQuery;

  $rootScope.search = sQ;

  var tagId = sQ.match(/tagid\:([0-9]+)/i);
  if(tagId != null) {
    $rootScope.notes = paperworkNotesService.getNotesInTag(tagId[1]);
    $rootScope.note = null;
    // $rootScope.noteSelectedId = -1;
  }
  $rootScope.navbarMainMenu = true;
  $rootScope.navbarSearchForm = true;
}).controller('paperworkFourOhFourController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  $rootScope.navbarMainMenu = true;
  $rootScope.navbarSearchForm = true;
}).controller('paperworkFileUploadController', ['$scope', '$rootScope', '$location', '$routeParams', 'FileUploader', 'paperworkNotesService', function($scope, $rootScope, $location, $routeParams, FileUploader, paperworkNotesService) {
  var uploader = $scope.uploader = new FileUploader({
    url: $rootScope.uploadUrl
  });

  // var loadFileList = function() {
  //   var sel = $rootScope.getVersionSelectedId(true);
  //   console.log(sel);
  //     paperworkNotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), $rootScope.getNoteSelectedId(), sel.versionId, function(response) {
  //       $rootScope.fileList = response;
  //     });
  // };
  // loadFileList();

  uploader.filters.push({
    name: 'customFilter',
    fn: function(item /*{File|FileLikeObject}*/, options) {
        return this.queue.length < 10;
    }
  });

  uploader.onWhenAddingFileFailed = function(item /*{File|FileLikeObject}*/, filter, options) {
      console.info('onWhenAddingFileFailed', item, filter, options);
  };
  uploader.onAfterAddingFile = function(fileItem) {
      console.info('onAfterAddingFile', fileItem);
  };
  uploader.onAfterAddingAll = function(addedFileItems) {
      console.info('onAfterAddingAll', addedFileItems);
  };
  uploader.onBeforeUploadItem = function(item) {
      console.info('onBeforeUploadItem', item);
  };
  uploader.onProgressItem = function(fileItem, progress) {
      console.info('onProgressItem', fileItem, progress);
  };
  uploader.onProgressAll = function(progress) {
      console.info('onProgressAll', progress);
  };
  uploader.onSuccessItem = function(fileItem, response, status, headers) {
      console.info('onSuccessItem', fileItem, response, status, headers);
  };
  uploader.onErrorItem = function(fileItem, response, status, headers) {
      console.info('onErrorItem', fileItem, response, status, headers);
  };
  uploader.onCancelItem = function(fileItem, response, status, headers) {
      console.info('onCancelItem', fileItem, response, status, headers);
  };
  uploader.onCompleteItem = function(fileItem, response, status, headers) {
      console.info('onCompleteItem', fileItem, response, status, headers);
  };
  uploader.onCompleteAll = function() {
      console.info('onCompleteAll');
      loadFileList();
  };

  console.info('uploader', uploader);
}]).controller('paperworkMessageBoxController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  $scope.onClick = function(buttonId) {
    if(typeof buttonId == "undefined" || buttonId == null || buttonId == "") {
      return false;
    }

    var l = $rootScope.modalMessageBox.buttons.length;

    for(i=0; i<l; i++) {
      if($rootScope.modalMessageBox.buttons[i].id == buttonId) {
        if(typeof $rootScope.modalMessageBox.buttons[i].click != "undefined") {
          if($rootScope.modalMessageBox.buttons[i].click()) {
            $('#modalMessageBox').modal('hide');
          }
          return;
        }
      }
    }
  };
}).filter('convertdate', function () {
    return function (value) {
        return (!value) ? '' : value.replace(/ /g, 'T');
    };
});