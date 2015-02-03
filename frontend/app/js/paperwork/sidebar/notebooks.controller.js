angular.module('paperworkNotes').controller('SidebarNotebooksController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotebooksService',
   function($scope, $rootScope, $location, $routeParams, notebooksService) {
     $rootScope.notebookSelectedId = 0;
     $rootScope.tagsSelectedId = -1;

     $scope.isVisible = function() {
       return !$rootScope.expandedNoteLayout;
     };

     $scope.notebookIconByType = function(type) {
       switch(parseInt(type)) {
         case 0:
           return 'fa-book';
           break;
         case 1:
           return 'fa-folder-open';
           break;
         case 2:
           return 'fa-archive';
           break;
       }
     };

     $rootScope.getNotebookSelectedId = function() {
       return $rootScope.notebookSelectedId;
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
         $rootScope.tagsSelectedId = -1;
         $rootScope.search = "";
         $location.path("/n/" + parseInt(notebookId));
       }
     };

     $scope.openTag = function(tagId) {
       $rootScope.notebookSelectedId = -1;
       $rootScope.tagsSelectedId = parseInt(tagId);
       $location.path("/s/tagid:" + parseInt(tagId));
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
           switch(status) {
             case 200:
               // FIXME
               $('#modalNotebook').modal('hide');
               _paperworkNotebooksService.getNotebooks();
               _paperworkNotebooksService.getNotebookShortcuts(null);
               break;
             case 400:
               if(typeof data.errors.title != "undefined") {
                 // FIXME
                 $('#modalNotebook').find('input[name="title"]').parents('.form-group').addClass('has-warning');
               }
               break;
           }
         };
       })(notebooksService);

       if($rootScope.modalNotebook.action == "create") {
         notebooksService.createNotebook(data, callback);
       } else if($rootScope.modalNotebook.action == "edit") {
         // if($rootScope.modalNotebook.delete) {
         // NotebooksService.deleteNotebook($rootScope.modalNotebook.id, callback);
         // } else {
         notebooksService.updateNotebook($rootScope.modalNotebook.id, data, callback);
         // }
       }
     };

     $scope.notebookSelectedModel = 0;
     $scope.modalNotebookSelectSubmit = function(notebookId, noteId, toNotebookId) {
       $rootScope.modalMessageBox.theCallback(notebookId, noteId, toNotebookId);
     };

     $scope.modalEditNotebook = function(notebookId) {
       var notebook = notebooksService.getNotebookByIdLocal(notebookId);

       if(notebook == null || $rootScope.menuItemNotebookClass() === 'disabled') {
         return false;
       }

       $rootScope.modalNotebook = {
         'action': 'edit',
         'id':     notebookId,
         'title':  notebook.title
       };

       var shortcut = notebooksService.getShortcutByNotebookIdLocal(notebookId);

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
               notebooksService.getNotebookShortcuts(null);
               notebooksService.getNotebooks();
               $location.path("/n/0");
               break;
             case 400:
               // TODO: Show some kind of error
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
               notebooksService.deleteNotebook(notebookId, callback);
               return true;
             },
           }
         ]
       });
     };

     notebooksService.getNotebookShortcuts(null);
     notebooksService.getNotebooks();
     $rootScope.tags = notebooksService.getTags();
   }]);
