angular.module('paperworkNotes').controller('ConstructorController',
  function($scope, $rootScope, $location, $routeParams, NetService, paperworkDbAllId) {
    if($rootScope.initDone) {
      return;
    }
    $rootScope.initDone = true;

    // We need to close popovers, else they will hang up if the ng-view is being switched.
    $('body').on('mousedown', function(e) {
      $('[data-toggle="popover"]').each(function() {
        if(!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
          $(this).popover('hide');
        }
      });
    });

    NetService.apiGet('/i18n', function(status, data) {
      if(status == 200) {
        $rootScope.i18n = data.response;
      }
    });

    $rootScope.modal = {
      'active': false,
      'next':   []
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
        $rootScope.modal.next.splice(0, 1);
      }
    });

    $('#modalNotebook').on('hidden.bs.modal', function(e) {
      $(this).find('input[name="title"]').parents('.form-group').removeClass('has-warning');
    });

    var $modal = $('.modal');

    $modal.on('hidden.bs.modal', function(e) {
      $rootScope.$broadcast('paperworkModalHidden', e);
    });

     $rootScope.menuItemNotebookClass = function() {
       if($rootScope.getNotebookSelectedId() != paperworkDbAllId) {
         return '';
       } else {
         return 'disabled';
       }
     };

    $rootScope.menuItemNotebookClass = function() {
      if($rootScope.getNotebookSelectedId() != 0) {
        return '';
      } else {
        return 'disabled';
      }
    };

    $rootScope.menuItemNoteClass = function(availabilityType) {
      if($rootScope.getNoteSelectedId(true) != null && typeof $rootScope.notes != "undefined" && $rootScope.notes.length > 0) {
        if(availabilityType == 'single' && $rootScope.editMultipleNotes == true) {
          return 'disabled';
        } else {
          return '';
        }
      } else {
        return 'disabled';
      }
    };

    $rootScope.getVersionSelectedId = function(asObject) {
      if(asObject === true) {
        return $rootScope.versionSelectedId;
      }
      return $rootScope.versionSelectedId.notebookId + "-" + $rootScope.versionSelectedId.noteId + "-" + $rootScope.versionSelectedId.versionId;
    };

    $rootScope.modalGeneric = function(modalId, modalData) {
      var callback = function(data) {
        $rootScope.modalMessageBox = data;
        $('#' + modalId).modal('show');
      };
      if($rootScope.modal.active === false) {
        callback(modalData);
      } else {
        $rootScope.modal.next.push({
          'id':       modalId,
          'callback': function() {
            callback(modalData);
          }
        });
      }
    };

    $rootScope.messageBox = function(messageBoxData) {
      $rootScope.modalGeneric('modalMessageBox', messageBoxData);
    };

    $rootScope.modalNotebookSelect = function(modalData) {
      $rootScope.modalGeneric('modalNotebookSelect', modalData);
    };
    
    $rootScope.modalUsersSelect = function(modalData){
      if (!('noteId' in modalData)) {
        $rootScope.modalGeneric('modalUsersNotebookSelect',modalData);
      }else{
        $rootScope.modalGeneric('modalUsersSelect',modalData);
      }
    }
    
  });
