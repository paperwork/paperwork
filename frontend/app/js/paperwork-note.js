var paperworkApi = '/api/v1';

angular.module("paperworkNotes", ['ngRoute'])
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
  .when('/n/:notebookId/note/new', {
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

  paperworkNotebooksServiceFactory.selectedNotebookId = 0;

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

  paperworkNotesServiceFactory.selectedNoteIndex = 0;

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
    $rootScope.note = null;
    // $location.path("/notebook/" + $scope.notebookSelectedId + "/note/" + $rootScope.notes[0].id);
}).controller('paperworkNotesShowController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
  $rootScope.noteSelectedId = parseInt($routeParams.notebookId) + "-" + parseInt($routeParams.noteId);
  if(typeof $routeParams.searchQuery == "undefined" || $routeParams.searchQuery == null || $routeParams.searchQuery.length <= 0) {
    paperworkNotesService.getNotesInNotebook(parseInt($routeParams.notebookId));
    $rootScope.notebookSelectedId = parseInt($routeParams.notebookId);
  }
  paperworkNotesService.getNoteById(parseInt($routeParams.noteId));
  // window.setupWaybackTimeline();
}).controller('paperworkNotesEditController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
  paperworkNotesService.getNoteById(parseInt($routeParams.noteId));
}).controller('paperworkNotesListController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
    $rootScope.noteSelectedId = -1;
    paperworkNotesService.getNotesInNotebook(0);

    $scope.noteSelect = function($notebookId, $noteId) {
      $rootScope.noteSelectedId = parseInt($notebookId) + "-" + parseInt($noteId);
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
  }

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
  }

  $scope.getNotebookSelectedId = function() {
    return $rootScope.notebookSelectedId;
  }

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
  }

  $scope.modalNewNotebook = function() {
    $rootScope.modalNotebook = {
      action: "create"
    };
    $('#modalNotebook').modal("show");
  }

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
  }

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
  }

  $rootScope.shortcuts = paperworkNotebooksService.getNotebookShortcuts(null);
  $rootScope.notebooks = paperworkNotebooksService.getNotebooks();
  $rootScope.tags = paperworkNotebooksService.getTags();

  $('#modalNotebook').on('hidden.bs.modal', function (e) {
    $scope.modalNotebookTitle = "";
    $scope.modalNotebookShortcut = false;
    $(this).find('input[name="title"]').parents('.form-group').removeClass('has-warning');
  });
}).controller('paperworkSidebarNotesController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){

  $scope.isVisible = function() {
    if($location.$$path.match(/^\/n\/[0-9]+\/[0-9]+\/edit/g) == null) {
      return true;
    } else {
      return false;
    }
  }

  $scope.getNoteSelectedId = function() {
    return $rootScope.noteSelectedId;
  }

  $scope.submitSearch = function() {
    if($scope.search == "") {
      $location.path("/");
    } else {
      $location.path("/s/" + encodeURIComponent($scope.search));
    }
  }
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
}).controller('paperworkFourOhFourController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){

}).filter('convertdate', function () {
    return function (value) {
        return (!value) ? '' : value.replace(/ /g, 'T');
    };
});