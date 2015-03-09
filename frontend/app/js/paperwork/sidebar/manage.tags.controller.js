angular.module('paperworkNotes').controller('SidebarManageTagsController',
  function($scope, $rootScope, $location, $routeParams, NotebooksService) {
    $scope.modalTags = [];

    $('#modalManageTags').on('hidden.bs.modal', function(e) {
      $scope.modalTags = [];
      $scope.$apply();    // Because not angular scope
    });
    $('#modalManageTags').on('show.bs.modal', function(e) {
      $scope.modalTags = $rootScope.tags;
    });

    $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
      $('#modalManageTags .line').editable({
        mode:   'inline',
        params: function(params) {
          return {
            id:    params.pk,
            title: params.value
          };
        },
        url:    function(data) {
          NotebooksService.updateTag(data.id, data, function(status, responseData) {
            switch(status) {
              case 200:
                NotebooksService.getTags();
                break;
              case 400:
                for(var i in responseData.errors) {
                  var msg = responseData.errors[i];
                  break;
                }
                $('#modalManageTags').find(".line[data-pk='" + data.id + "']").tooltip({
                  title:   msg,
                  trigger: 'manual'
                }).tooltip('show');
                break;
            }
          });
        }
      }).on('shown', function(e, editable) {
        editable.$element.tooltip('destroy');
      });
    });

    $scope.deleteTag = function(tagId) {
      $rootScope.modalMessageBox = {
        'title':   $rootScope.i18n.keywords.delete_tag_question,
        'content': $rootScope.i18n.keywords.delete_tag_message,
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
              NotebooksService.deleteTag(tagId, function() {
                NotebooksService.getTags();
                $('#modalManageTags').find(".line[data-pk='" + tagId + "']").closest('.row').remove();
              });
              return true;
            }
          }
        ]
      };
      $('#modalMessageBox').modal('show');
    }
  });
