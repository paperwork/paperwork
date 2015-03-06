angular.module('paperworkNotes').controller('ViewController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService',
   function($scope, $rootScope, $location, $routeParams, notesService) {
     $scope.isVisible = function() {
       return !$rootScope.expandedNoteLayout;
     }
   }]);
