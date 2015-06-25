angular.module('paperworkNotes').controller('SidebarNotebooksController',
   function($scope, $rootScope, $location, $routeParams, $filter, $q, NotebooksService, NotesService, paperworkDbAllId, StatusNotifications, NetService) {
     $rootScope.notebookSelectedId = paperworkDbAllId;
     $rootScope.tagsSelectedId = -1;
     $rootScope.dateSelected = -1;
     $scope.shortcutsCollapsed=false;
     $scope.notebooksCollapsed=false;
     $scope.tagsCollapsed=false;
     $scope.calentdarCollapsed=false;
    

    $scope.isVisible = function() {
      return !$rootScope.expandedNoteLayout;
    };

    $scope.notebookIconByType = function(type) {
      switch(parseInt(type)) {
        case 0:
          return 'fa-book';
        case 1:
          return 'fa-folder-open';
        case 2:
          return 'fa-archive';
      }
    };

    $rootScope.getNotebookSelectedId = function() {
      return $rootScope.notebookSelectedId;
    };

    
    $scope.getUsers = function (notebookId, propagationToNotes, update){
        if(typeof $rootScope.i18n != "undefined")
	    $rootScope.umasks=[{'name':$rootScope.i18n.keywords.not_shared, 'value':0},
		   {'name':$rootScope.i18n.keywords.read_only, 'value':4},
		   {'name':$rootScope.i18n.keywords.read_write, 'value':6}];
        $rootScope.showWarningNotebook=false;
        $rootScope.showWarningNotes=false;
	NetService.apiGet('/users/notebooks/'+notebookId, function(status, data) {
        if(status == 200) {
		if(update && $rootScope.users.length==data.response.length){
			angular.forEach($rootScope.users,function(value,key){
				value['owner']=data.response[key]['owner'];
			});
		}else{
        	  $rootScope.users = data.response;
		}
          angular.forEach($rootScope.users, function(value,key){
                if (value['is_current_user'] && ! value['owner']) {
                  $rootScope.showWarningNotebook=true;
                }
            });
        }
        if (propagationToNotes) {
          noteId=[];
          angular.forEach($rootScope.notes, function(value,key){
            noteId.push(value['id']);
          });
          NetService.apiGet('/users/'+noteId, function(status, data){
            if (status==200) {
              angular.forEach($rootScope.users, function(value,key){
                value['owner']=data.response[key]['owner'];
                if (value['is_current_user'] && ! value['owner']) {
                  $rootScope.showWarningNotes=true;
                }
              });
            }
          });
        }
      });
    };
    
    $scope.openNotebook = function(notebookId, type, index) {
      if(parseInt(type) == 0 || parseInt(type) == 2) {
        // If the notebooks tree should be collapsed, expand it,
        // so the user sees which notebook is being selected through the shortcut.
        var $treeHeaderNotebooks = jQuery('.tree-header-notebooks');
        if($treeHeaderNotebooks.children('.fa').hasClass('fa-chevron-right')) {
          $treeHeaderNotebooks.click();
        }

         $rootScope.notebookSelectedId = parseInt(index);
         $rootScope.dateSelected = -1;
         $rootScope.tagsSelectedId = -1;
         $rootScope.search = "";
         $location.path("/n/" + (notebookId));
       }
     };

    $scope.openFilter = function() {
      var s = "";
      if($rootScope.notebookSelectedId != 0) {
        s += "notebookid:" + $rootScope.notebookSelectedId;
      }

      if($rootScope.tagsSelectedId != -1) {
        if (s.length > 0) s += " ";
        s += "tagid:" + $rootScope.tagsSelectedId;
      }

      if($rootScope.dateSelected != -1) {
        if (s.length > 0) s += " ";
        s += "date:" + $filter('date')($rootScope.dateSelected, 'yyyy-MM-dd');
      }

      $rootScope.search = s;
      if(s.length) {
        $location.path("/s/" + $rootScope.search);
      } else {
        $location.path("/n/" + paperworkDbAllId);
      }
    };

    $rootScope.openTag = function(tagId) {
      if($rootScope.tagsSelectedId === tagId) {
        $rootScope.tagsSelectedId = -1;
      } else {
        $rootScope.tagsSelectedId = tagId;
      }

      $rootScope.notebookSelectedId = 0;
      $rootScope.dateSelected = -1;

      $scope.openFilter();
    };

    $scope.openDate = function(date) {
      if($filter('date')($rootScope.dateSelected, "shortDate") === $filter('date')(date, "shortDate")) {
        $rootScope.dateSelected = -1;
        $scope.sidebarCalendar = undefined;
      } else {
        $rootScope.dateSelected = date;
      }

      $scope.openFilter();
    };

    $scope.modalNewNotebook = function() {
      $rootScope.modalNotebook = {
        'action':   'create',
        'shortcut': '',
        'title':    ''
      };
      $('#modalNotebook').modal("show");
    };

    $scope.modalNotebookSubmit = function() {
      var data = {
        'type':     0,
        'title':    $rootScope.modalNotebook.title,
        'shortcut': $rootScope.modalNotebook.shortcut
      };

      var callback = (function(_paperworkNotebooksService) {
        return function(status, data) {
          var param;
          var action = $rootScope.modalNotebook.action;
          switch(status) {
            case 200:
              // FIXME
              $('#modalNotebook').modal('hide');
              _paperworkNotebooksService.getNotebooks();
              _paperworkNotebooksService.getNotebookShortcuts(null);
              param = "notebook_" + action + "_successfully";
              StatusNotifications.sendStatusFeedback("success", param);
              break;
            case 400:
              if(typeof data.errors.title != "undefined") {
                // FIXME
                $('#modalNotebook').find('input[name="title"]').parents('.form-group').addClass('has-warning');
              }
              //param = "notebook_" + action + "_failed";
              //StatusNotifications.sendStatusFeedback("error", param);
              break;
            default:
              param = "notebook_" + action + "_failed";
              StatusNotifications.sendStatusFeedback("error", param);
              break;
          }
        };
      })(NotebooksService);

      if($rootScope.modalNotebook.action == "create") {
        NotebooksService.createNotebook(data, callback);
      } else if($rootScope.modalNotebook.action == "edit") {
        // if($rootScope.modalNotebook.delete) {
        // NotebooksService.deleteNotebook($rootScope.modalNotebook.id, callback);
        // } else {
        NotebooksService.updateNotebook($rootScope.modalNotebook.id, data, callback);
        // }
      }
    };

    $scope.notebookSelectedModel = 0;
    $scope.modalNotebookSelectSubmit = function(notebookId, noteId, toNotebookId) {
      $rootScope.modalMessageBox.theCallback(notebookId, noteId, toNotebookId);
    };

    $scope.modalEditNotebook = function(notebookId) {
      var notebook = NotebooksService.getNotebookByIdLocal(notebookId);

      if(notebook == null || $rootScope.menuItemNotebookClass() === 'disabled') {
        return false;
      }

      $rootScope.modalNotebook = {
        'action': 'edit',
        'id':     notebookId,
        'title':  notebook.title
      };

      var shortcut = NotebooksService.getShortcutByNotebookIdLocal(notebookId);

      if(shortcut == null) {
        $rootScope.modalNotebook.shortcut = false;
      } else {
        $rootScope.modalNotebook.shortcut = true;
      }

      // FIXME
      $('#modalNotebook').modal("show");
    };

    $scope.modalDeleteNotebook = function(notebookId) {

      if($rootScope.menuItemNotebookClass() === 'disabled') {
        return false;
      }

      var callback = (function() {
        return function(status, data) {
          switch(status) {
            case 200:
              NotebooksService.getNotebookShortcuts(null);
              NotebooksService.getNotebooks();
              $location.path("/n/0" + paperworkDbAllId);
              StatusNotifications.sendStatusFeedback("success", "notebook_deleted_successfully");
              break;
            case 400:
              StatusNotifications.sendStatusFeedback("error", "notebook_delete_fail");
              break;
          }
        };
      })();

      $rootScope.messageBox({
        'title':   $rootScope.i18n.keywords.delete_notebook_question,
        'content': $rootScope.i18n.keywords.delete_notebook_message,
        'buttons': [
          {
            // We don't need an id for the dismiss button.
            // 'id': 'button-no',
            'label':     $rootScope.i18n.keywords.cancel,
            'isDismiss': true
          },
          {
            'id':    'button-yes',
            'label': $rootScope.i18n.keywords.yes,
            'class': 'btn-warning',
            'click': function() {
              NotebooksService.deleteNotebook(notebookId, callback);
              return true;
            },
          }
        ]
      });
    };
    
    $rootScope.propagationToNotes=false;
    $scope.modalShareNotebook = function(notebookId){
      if($rootScope.menuItemNotebookClass() === 'disabled') {
        return false;
      }
      $scope.getUsers(notebookId, $rootScope.propagationToNotes,false);
      $rootScope.modalUsersSelect({
        'notebookId': notebookId,
        'theCallback':function(notebookId,toUsers, propagationToNotes){
          toUserId=[]
          toUMASK=[]
          angular.forEach(toUsers, function(user,key){
              if (!user['is_current_user']) {
              toUserId.push(user['id']);
              toUMASK.push(user['umask']);
              }
            });
          NotebooksService.shareNotebook(notebookId,toUserId, toUMASK, function(_notebookId){
            $('#modalUsersNotebookSelect').modal('hide');
            $location.path("/n/"+(_notebookId));
            if (propagationToNotes) {
              noteId=[]
              angular.forEach($rootScope.notes, function(value,key){
                noteId.push(value['id']);
              });
              NotesService.shareNote(_notebookId,noteId,toUserId, toUMASK,function(){});
            }
          });
          return true;
        }
      });
      
    };
    $scope.modalUsersNotebookSelectSubmit = function(notebookId, toUserId, propagationToNotes) {
      $rootScope.modalMessageBox.theCallback(notebookId, toUserId, propagationToNotes);
    };
    
    $scope.modalUsersNotebookSelectCheck = function(notebookId,_prop){
      $rootScope.propagationToNotes=_prop;
      $scope.getUsers(notebookId, _prop, true);  
    }

    $scope.onDragSuccess = function(data, event) {
      //u
    };
    
    $scope.onDropSuccess = function(data, event) {
      NotesService.moveNote($rootScope.note.notebook_id, $rootScope.note.id, this.notebook.id);
      // Try to make the openNotebook dependant on the result of the move
      $scope.openNotebook(this.notebook.id, this.notebook.type, this.notebook.id);
    };

    $scope.modalManageTags = function() {
      $('#modalManageTags').modal("show");
    };

    $scope.onDropToTag = function(data, event) {
	toid=this.tag.id;
	if('visibility' in data){
	    //we're dragging a tag
	    NotebooksService.nestTag(data.id, toid, function(status,responseData){
            switch(status) {
              case 200:
                NotebooksService.getTags();
                break;
              case 400:
                for(var i in responseData.errors) {
                  var msg = responseData.errors[i];
                  break;
                }
                break;
            }
});
	    $scope.openTag(data.id);
	}else{
	    //we're dragging a note
	    if ('child' in this) {
		toid=this.child.id;
	    }
	    NotesService.tagNote($rootScope.note.notebook_id, $rootScope.note.id, toid);
	    $scope.openTag(toid);
	}
    };

    $scope.modalManageNotebooks = function() {
      $('#modalManageNotebooks').modal("show");
    };

    var sidebarCalendarDefer = $q.defer();

    $scope.sidebarCalendarEnabledDates = [];
    $scope.sidebarCalendarPromise = sidebarCalendarDefer.promise;
    $scope.sidebarCalendarIsDisabled = function(date, mode) {
      if(mode !== "day") {
        return false;
      }

      var shortDate = $filter('date')(date, "yyyy-MM-dd");
      return $.inArray(shortDate, $scope.sidebarCalendarEnabledDates) == -1;
    };

    $scope.sidebarCalendarCallback = function(data) {
      while($scope.sidebarCalendarEnabledDates.length) {
        $scope.sidebarCalendarEnabledDates.pop();
      }

      $.each(data, function(key) {
        $scope.sidebarCalendarEnabledDates.push(key);
      });

      sidebarCalendarDefer.notify(new Date().getTime());
    };

    NotebooksService.getCalendar($scope.sidebarCalendarCallback);
    NotebooksService.getNotebookShortcuts(null);
    NotebooksService.getNotebooks();
    NotebooksService.getTags();
  });
