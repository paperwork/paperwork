var paperworkApi = '/api/v1';

angular.module("paperworkNotes", ['ngRoute']).factory('paperworkNotebooksService', ['$rootScope', '$http', function($rootScope, $http) {
  var paperworkNotebooksServiceFactory = {};

  paperworkNotebooksServiceFactory.selectedNotebookId = 0;

  paperworkNotebooksServiceFactory.createNotebook = function(callback, notebookTitle, notebookShortcut) {
    var data = { 'title': notebookTitle, 'shortcut': notebookShortcut };

    $http.post(paperworkApi + '/notebooks', data).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
        console.log("Error receiving data for /notebooks");
        return null;
      });
  };

  paperworkNotebooksServiceFactory.getNotebooks = function() {
    $http({method: 'GET', url: paperworkApi + '/notebooks'}).
      success(function(data, status, headers, config) {
        $rootScope.notebooks = data;
        return $rootScope.notebooks;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /notebooks");
        return null;
      });
  };

  paperworkNotebooksServiceFactory.getNotebookById = function(notebookId) {
    $http({method: 'GET', url: paperworkApi + '/notebooks/' + notebookId}).
      success(function(data, status, headers, config) {
        return data;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /notebooks/" + notebookId);
        return null;
      });
  };

  paperworkNotebooksServiceFactory.getNotebookShortcuts = function(shortcuts) {
    $http({method: 'GET', url: paperworkApi + '/shortcuts'}).
      success(function(data, status, headers, config) {
        $rootScope.shortcuts = data;
        return $rootScope.shortcuts;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /shortcuts");
        return null;
      });
  }

  paperworkNotebooksServiceFactory.getTags = function() {
    $http({method: 'GET', url: paperworkApi + '/tags'}).
      success(function(data, status, headers, config) {
        $rootScope.tags = data;
        return $rootScope.tags;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /tags");
        return null;
      });
  };

  return paperworkNotebooksServiceFactory;
}]).factory('paperworkNotesService', ['$rootScope', '$http', function($rootScope, $http) {
  var paperworkNotesServiceFactory = {};

  paperworkNotesServiceFactory.selectedNoteIndex = 0;

  paperworkNotesServiceFactory.getNotesInNotebook = function(notebookId) {
    $http({method: 'GET', url: paperworkApi + '/notebooks/' + notebookId + '/notes'}).
      success(function(data, status, headers, config) {
        $rootScope.notes = data;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /notebooks/" + notebookId + "/notes");
        return null;
      });
  };

  paperworkNotesServiceFactory.getNotesInTag = function(tagId) {
    $http({method: 'GET', url: paperworkApi + '/tagged/' + tagId}).
      success(function(data, status, headers, config) {
        $rootScope.notes = data;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /tagged/" + tagId);
        return null;
      });
  };

  paperworkNotesServiceFactory.getNoteById = function(noteId) {
    $http({method: 'GET', url: paperworkApi + '/notebooks/0/notes/' + noteId}).
      success(function(data, status, headers, config) {
        $rootScope.note = data;
      }).
      error(function(data, status, headers, config) {
        console.log("Error receiving data for /notebooks/0/notes/" + noteId);
        return null;
      });
  };

  return paperworkNotesServiceFactory;
}]).config(function($routeProvider) {
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
}).controller('paperworkDefaultController', function($scope, $location, $routeParams, paperworkNotesService) {
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
  window.setupWaybackTimeline();
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

  $scope.createNotebook = function() {
    paperworkNotebooksService.createNotebook((function(_paperworkNotebooksService) {
      return function(status, data) {
        switch(status) {
          case 200:
            $('#modalNewNotebook').modal('hide');
            _paperworkNotebooksService.getNotebooks();
            break;
          case 400:
            console.log(data);
            if(typeof data.errors.title != "undefined") {
              $('#modalNewNotebook').find('input[name="title"]').parents('.form-group').addClass('has-warning');
            }
            break;
        }
      };
    })(paperworkNotebooksService), $scope.createNotebookTitle, $scope.createNotebookShortcut);
  }

  $rootScope.shortcuts = paperworkNotebooksService.getNotebookShortcuts(null);
  $rootScope.notebooks = paperworkNotebooksService.getNotebooks();
  $rootScope.tags = paperworkNotebooksService.getTags();

  $('#modalNewNotebook').on('hidden.bs.modal', function (e) {
    $scope.createNotebookTitle = "";
    $scope.createNotebookShortcut = false;
    $(this).find('input[name="title"]').parents('.form-group').removeClass('has-warning');
  })
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
    $location.path("/s/" + encodeURIComponent($scope.search));
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