paperworkModule.controller('paperworkViewController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  $scope.isVisible = function() {
    return !$rootScope.expandedNoteLayout;
  }
});