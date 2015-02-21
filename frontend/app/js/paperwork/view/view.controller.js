angular.module('paperworkNotes').controller('ViewController',
  function($scope, $rootScope, $location, $routeParams, NotesService) {
    $scope.isVisible = function() {
      return !$rootScope.expandedNoteLayout;
    }
  });
