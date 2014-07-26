var paperworkApi = '/api/v1';

angular.module("paperworkNotes", ['ngRoute', 'ngSanitize', 'ngAnimate'])
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
        $rootScope.notebooks = data;
      }
    });
  };

  paperworkNotebooksServiceFactory.getNotebookById = function(notebookId) {
    paperworkNetService.apiGet('/notebooks/' + notebookId, function(status, data) {
      if(status == 200) {
        $rootScope.notebook = data;
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
        $rootScope.shortcuts = data;
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
        $rootScope.tags = data;
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

  paperworkNotesServiceFactory.getNotesInNotebook = function(notebookId) {
    paperworkNetService.apiGet('/notebooks/' + notebookId + '/notes', function(status, data) {
      if(status == 200) {
        $rootScope.notes = data;
      }
    });
  };

  paperworkNotesServiceFactory.getNotesInTag = function(tagId) {
    paperworkNetService.apiGet('/tagged/' + tagId, function(status, data) {
      if(status == 200) {
        $rootScope.notes = data;
      }
    });
  };

  paperworkNotesServiceFactory.getNoteById = function(noteId) {
    paperworkNetService.apiGet('/notebooks/0/notes/' + noteId, function(status, data) {
      if(status == 200) {
        $rootScope.note = data;
      }
    });
  };

  return paperworkNotesServiceFactory;
}]).controller('paperworkDefaultController', function($scope, $location, $routeParams, paperworkNotesService) {
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
  $rootScope.noteSelectedId = { 'notebookId': parseInt($routeParams.notebookId), 'noteId': parseInt($routeParams.noteId) };
  if(typeof $routeParams.searchQuery == "undefined" || $routeParams.searchQuery == null || $routeParams.searchQuery.length <= 0) {
    paperworkNotesService.getNotesInNotebook(parseInt($routeParams.notebookId));
    $rootScope.notebookSelectedId = parseInt($routeParams.notebookId);
  }
  paperworkNotesService.getNoteById(parseInt($routeParams.noteId));
  $rootScope.navbarMainMenu = true;
  $rootScope.navbarSearchForm = true;

  // window.setupWaybackTimeline();
}).controller('paperworkNotesEditController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
  paperworkNotesService.getNoteById(parseInt($routeParams.noteId));
  $rootScope.templateNoteEdit = {};

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

  $rootScope.navbarMainMenu = false;
  $rootScope.navbarSearchForm = false;
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
    if($location.$$path.match(/^\/n\/[0-9]+\/[0-9]+\/edit/g) == null) {
      return true;
    } else {
      return false;
    }
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
      action: "create"
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
      if($rootScope.modalNotebook.delete) {
        paperworkNotebooksService.deleteNotebook($rootScope.modalNotebook.id, callback);
      } else {
        paperworkNotebooksService.updateNotebook($rootScope.modalNotebook.id, data, callback);
      }
    }
  };

  $scope.modalEditNotebook = function(notebookId, deleteIt) {
    var notebook = paperworkNotebooksService.getNotebookByIdLocal(notebookId);

    if(notebook == null) {
      return false;
    }

    $rootScope.modalNotebook = {
      'action': 'edit',
      'id': notebookId,
      'title': notebook.title,
      'delete': deleteIt
    };

    var shortcut = paperworkNotebooksService.getShortcutByNotebookIdLocal(notebookId);

    if(shortcut == null) {
      $rootScope.modalNotebook.shortcut = false;
    } else {
      $rootScope.modalNotebook.shortcut = true;
    }
    $('#modalNotebook').modal("show");
  };

  $rootScope.shortcuts = paperworkNotebooksService.getNotebookShortcuts(null);
  $rootScope.notebooks = paperworkNotebooksService.getNotebooks();
  $rootScope.tags = paperworkNotebooksService.getTags();

  $('#modalNotebook').on('hidden.bs.modal', function (e) {
    $scope.modalNotebookTitle = "";
    $scope.modalNotebookShortcut = false;
    $(this).find('input[name="title"]').parents('.form-group').removeClass('has-warning');
  });
}).controller('paperworkSidebarNotesController', function($scope, $rootScope, $location, $timeout, $routeParams, paperworkNotesService){

  $scope.isVisible = function() {
    if($location.$$path.match(/^\/n\/[0-9]+\/[0-9]+\/edit/g) == null) {
      return true;
    } else {
      return false;
    }
  };

  $rootScope.getNoteSelectedId = function(asObject) {
    if(asObject === true) {
      return $rootScope.noteSelectedId;
    }
    return $rootScope.noteSelectedId.notebookId + "-" + $rootScope.noteSelectedId.noteId;
  };

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

  $scope.updateNote = function() {
    $rootScope.note.content = CKEDITOR.instances.content.getData();

    var data = {
      'title': $rootScope.note.title,
      'content': $rootScope.note.content
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
    if($rootScope.templateNoteEdit.modified) {
      // TODO: Ask!
    }
    var currentNote = $rootScope.getNoteSelectedId(true);
    $location.path("/n/" + $rootScope.getNotebookSelectedId() + "/" + currentNote.noteId);
  };

  $scope.deleteNote = function() {
    if(typeof $rootScope.templateNoteEdit == "undefined" || $rootScope.templateNoteEdit == null) {
      $rootScope.templateNoteEdit = {
        'delete': 0
      };
    }
    if($rootScope.templateNoteEdit.delete == 1) {
      var callback = (function() {
        return function(status, data) {
          switch(status) {
            case 200:
              // TODO: Show cool success message
              $rootScope.templateNoteEdit.delete = 0;
              $location.path("/n/" + $rootScope.notebookSelectedId);
              break;
            case 400:
              // TODO: Show some kind of error
              break;
          }
        };
      })();
      paperworkNotesService.deleteNote($rootScope.note.id, callback);
    } else {
      $rootScope.templateNoteEdit.delete = 1;
      $timeout(function() {
        console.log($rootScope.templateNoteEdit.delete);
        $rootScope.templateNoteEdit.delete = 0;
      }, 3000)
    }
  }

  $scope.submitSearch = function() {
    if($scope.search == "") {
      $location.path("/");
    } else {
      $location.path("/s/" + encodeURIComponent($scope.search));
    }
  };
}).controller('paperworkViewController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  $scope.isVisible = function() {
    if($location.$$path.match(/^\/n\/[0-9]+\/[0-9]+\/edit/g) == null) {
      return true;
    } else {
      return false;
    }
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
}).filter('convertdate', function () {
    return function (value) {
        return (!value) ? '' : value.replace(/ /g, 'T');
    };
});