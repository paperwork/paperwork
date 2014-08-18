paperworkModule.controller('paperworkMessageBoxController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService){
  $scope.onClick = function(buttonId) {
    if(typeof buttonId == "undefined" || buttonId == null || buttonId == "") {
      return false;
    }

    var l = $rootScope.modalMessageBox.buttons.length;

    for(i=0; i<l; i++) {
      if($rootScope.modalMessageBox.buttons[i].id == buttonId) {
        if(typeof $rootScope.modalMessageBox.buttons[i].click != "undefined") {
          if($rootScope.modalMessageBox.buttons[i].click()) {
            $('#modalMessageBox').modal('hide');
          }
          return;
        }
      }
    }
  };
});