paperworkModule.config(function($routeProvider) {
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
});
