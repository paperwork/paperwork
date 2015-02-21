angular.module('paperworkNotes').controller('ViewController',
  function($scope, $rootScope, $location, $routeParams, notesService) {
    $scope.isVisible = function() {
      return !$rootScope.expandedNoteLayout;
    }
  });
