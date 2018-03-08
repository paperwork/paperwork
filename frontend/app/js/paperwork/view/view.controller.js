angular.module('paperworkNotes').controller('ViewController',
  function($scope, $rootScope, $location, $routeParams, NotesService) {
    $scope.isVisible = function() {
      return !$rootScope.expandedNoteLayout;
    };

    $scope.getStyleClasses = function(notesLength, sidebarCollapsed) {

      // Define the classes variable
      var classes = "",
          xs = 12,
          sm = 12,
          md = 12;

      // Check if the note screen needs to be full screen
      if ($scope.isVisible()) {

        // Make space for sidebar
        if (!sidebarCollapsed) {
          sm -= 3;
          md -= 2;
        }

        // Make space for the notes switcher
        if ($rootScope.notes.length > 0) {
          sm -= 4;
          md -= 3;
        }

      }

      // Assign the appropriate column numbers
      classes = "col-xs-" + xs + " col-sm-" + sm + " col-md-" + md;

      // Set up the appropriate offset
      classes += " col-xs-offset-" + (12 - xs) + " col-sm-offset-" + (12 - sm) + " col-md-offset-" + (12 - md);

      // Return the correct dimension
      return classes;

    };

  });
