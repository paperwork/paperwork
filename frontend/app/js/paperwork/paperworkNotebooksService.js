paperworkModule.factory('paperworkNotebooksService', ['$rootScope', '$http', 'paperworkNetService', function($rootScope, $http, paperworkNetService) {
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
}]);