angular.module('paperworkNotes').controller('SidebarManageNotebooksController',
  function($scope, $rootScope, $location, $routeParams, NotebooksService) {
    $scope.modalList = [];

    $('#modalManageNotebooks').on('hidden.bs.modal', function(e) {
      //$scope.modalList = [];
      //$scope.$apply();    // Because not angular scope
    });

    //$('#modalManageNotebooks').on('show.bs.modal', function (e) {
    // Added watch to rebuild list when we add new element
    $rootScope.$watch('notebooks', function(newValue, oldValue) {
      // Remove 'All Notes' item
      var data = ($.isArray($rootScope.notebooks)) ? $rootScope.notebooks.slice() : [];
      for(var i in data) {
        if(data[i].id == 0) {
          data.splice(i, 1);
          break;
        }
      }
      $scope.modalList = data;
    });

    var buildShortcutChk = function(editable, newRow) {
      var shortcut = false;
      if(!newRow) {
        shortcut = !!NotebooksService.getShortcutByNotebookIdLocal(editable.options.pk);
      }

      editable.container.$form.find('.control-group').after(
        $('<div/>').addClass('checkbox shortcut-chk').append(
          $('<label/>').append(
            $('<input/>').attr({
              'type':  'checkbox',
              'name':  'shortcut',
              'value': '1'
            }).prop('checked', shortcut)
          ).append($rootScope.i18n.notebooks.add_shortcut)
        )
      );
    };

    var parseParams = function(params) {
      return {
        id:       params.pk,
        title:    params.value,
        shortcut: $(this).parent().find("input[name='shortcut']").is(':checked'),
        type:     0
      };
    };

    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
      $('#modalManageNotebooks .line').editable({
        params:       parseParams,
        send:         'always',
        savenochange: true,
        url:          function(data) {
          NotebooksService.updateNotebook(data.id, data, function(status, responseData) {
            switch(status) {
              case 200:
                NotebooksService.getNotebooks();
                NotebooksService.getNotebookShortcuts(null);
                break;
              case 400:
                for(var i in responseData.errors) {
                  var msg = responseData.errors[i];
                  break;
                }
                $('#modalManageNotebooks').find(".line[data-pk='" + data.id + "']").tooltip({
                  title:   msg,
                  trigger: 'manual'
                }).tooltip('show');
                break;
            }
          });
        }
      }).on('shown', function(e, editable) {
        buildShortcutChk(editable, false);
        editable.$element.tooltip('destroy');
      });
    });

    $scope.deleteItem = function(id) {
      $rootScope.modalMessageBox = {
        'title':   $rootScope.i18n.keywords.delete_notebook_question,
        'content': $rootScope.i18n.keywords.delete_notebook_message,
        'buttons': [
          {
            'label':     $rootScope.i18n.keywords.cancel,
            'isDismiss': true
          },
          {
            'id':    'button-yes',
            'label': $rootScope.i18n.keywords.yes,
            'class': 'btn-warning',
            'click': function() {
              NotebooksService.deleteNotebook(id, function(status, data) {
                NotebooksService.getNotebooks();
                NotebooksService.getNotebookShortcuts();
              });
              $('#modalManageNotebooks').find(".line[data-pk='" + id + "']").closest('.row').remove();
              return true;
            }
          }
        ]
      };
      $('#modalMessageBox').modal('show');
    };

    $scope.addNotebook = function() {

      // build item
      var $row = $('<div/>').addClass('row')
        .append(
        $('<div/>').addClass('col-sm-10').append(
          $('<a/>').addClass('line').data('name', 'title')
        )
      )
        .append(
        $('<div/>').addClass('col-sm-2')
      );

      $row.find('a').editable({
        params: parseParams,
        url:    function(data) {
          NotebooksService.createNotebook(data, function(status, responseData) {
            switch(status) {
              case 200:
                NotebooksService.getNotebooks();
                NotebooksService.getNotebookShortcuts(null);

                $row.remove();
                //$scope.modalList.push(responseData.response);  --- we will  use $watch instead
                break;
              case 400:
                for(var i in responseData.errors) {
                  var msg = responseData.errors[i];
                  break;
                }
                $row.find(".line").tooltip({
                  title:   msg,
                  trigger: 'manual'
                }).tooltip('show');

                setTimeout(function() {
                  $row.remove();
                }, 3000);
                break;
            }
          });
        }
      }).on('hidden', function(e, reason) {
        if(reason != 'save') {
          $row.remove();
        }
      }).on('shown', function(e, editable) {
        buildShortcutChk(editable, true);
        editable.$element.tooltip('destroy');
      });

      $('#modalManageNotebooks .manage-list-content').append($row);

      setTimeout(function() { // doesn't work without timeout
        $row.find('a').editable('show');
      }, 1);
    };
  });
