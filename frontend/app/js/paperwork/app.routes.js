angular.module('paperworkNotes').config(function($routeProvider) {
  $routeProvider
  .when('/', {
    redirectTo:'/n/0'
  })
  .when('/n/:notebookId', {
    controller:'NotesAllController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/n/:notebookId/:noteId', {
    controller: 'NotesShowController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/n/:notebookId/:noteId/edit', {
    controller:'NotesEditController',
    templateUrl:'templates/paperworkNoteEdit'
  })
  .when('/s/:searchQuery', {
    controller:'SearchController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/s/:searchQuery/n/:notebookId/:noteId', {
    controller:'NotesShowController',
    templateUrl:'templates/paperworkNoteShow'
  })
  .when('/404', {
    controller:'FourOhFourController',
    templateUrl:'templates/paperwork404'
  })
  .otherwise({
    redirectTo:'/404'
  });
});
