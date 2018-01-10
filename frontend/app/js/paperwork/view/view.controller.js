angular.module('paperworkNotes').controller('ViewController',
  function($scope, $rootScope, $location, $routeParams, NotesService) {
    $scope.isVisible = function() {
      return !$rootScope.expandedNoteLayout;
    };

    $scope.getStyleClasses = function(notesLength, sidebarCollapsed) {
      var classes = "",
          md = 0,
          sm = 0;

      if(!sidebarCollapsed) {
        md += 2;
        sm += 3;
      }

      if(notesLength > 0) {
        md += 3;
        sm += 4;
      }

      if(sm > 0) {
        classes += " col-sm-offset-" + sm + " col-sm-" + (12 - sm);
      }

      if(md > 0) {
        classes += " col-md-offset-" + md + " col-md-" + (12 - md);
      }

      return classes;
    };

  });
