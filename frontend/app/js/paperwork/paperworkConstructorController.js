paperworkModule.controller('paperworkConstructorController', function($scope, $rootScope, $location, $routeParams, paperworkNetService) {
    if($rootScope.initDone) {
      return;
    }
    $rootScope.initDone = true;

    paperworkNetService.apiGet('/i18n', function(status, data) {
      if(status == 200) {
        $rootScope.i18n = data.response;
      }
    });

    $rootScope.modal = {
      'active': false,
      'next': []
    };

    $rootScope.$on('paperworkModalVisible', function(ev, data) {
      $rootScope.modal.active = true;
    });

    $rootScope.$on('paperworkModalHidden', function(ev, data) {
      $rootScope.modal.active = false;

      if($rootScope.modal.next.length > 0) {
        if($rootScope.modal.next[0].callback) {
          $rootScope.modal.next[0].callback();
        }
        $rootScope.modal.next.splice(0,1);
      }
    });

    $('#modalNotebook').on('hidden.bs.modal', function (e) {
      $(this).find('input[name="title"]').parents('.form-group').removeClass('has-warning');
    });

    $('.modal').on('hidden.bs.modal', function(e) {
      $rootScope.$broadcast('paperworkModalHidden', e);
    });

    $('.modal').on('show.bs.modal', function(e) {
      $rootScope.$broadcast('paperworkModalVisible', e);
    });

    $rootScope.getVersionSelectedId = function(asObject) {
      if(asObject === true) {
        return $rootScope.versionSelectedId;
      }
      return $rootScope.versionSelectedId.notebookId + "-" + $rootScope.versionSelectedId.noteId + "-" + $rootScope.versionSelectedId.versionId;
    };


    $rootScope.messageBox = function(messageBoxData) {
      var callback = function(data) {
        $rootScope.modalMessageBox = data;
        $('#modalMessageBox').modal('show');
      };
      if($rootScope.modal.active === false) {
        callback(messageBoxData);
      } else {
        $rootScope.modal.next.push({
          'id': 'modalMessageBox',
          'callback': function() {
            callback(messageBoxData);
          }
        });
      }
    };
});