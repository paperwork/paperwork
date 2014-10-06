paperworkModule.controller('paperworkNotesEditController', function($scope, $rootScope, $location, $routeParams, paperworkNotesService) {
  var thisController = function(notebookId, noteId) {
    $rootScope.noteSelectedId = { 'notebookId': notebookId, 'noteId': noteId };
    $rootScope.versionSelectedId = { 'notebookId': notebookId, 'noteId': noteId, 'versionId': 0 };
    paperworkNotesService.getNoteById(noteId);
    $rootScope.templateNoteEdit = $rootScope.getNoteByIdLocal(noteId);
    if(typeof $rootScope.templateNoteEdit == "undefined" || $rootScope.templateNoteEdit == null) {
      $rootScope.templateNoteEdit = {};
    }


    paperworkNotesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId, $rootScope.getVersionSelectedId(true).versionId, function(response) {
      $rootScope.fileList = response;
    });

    var ck =  CKEDITOR.replace('content', {
      fullPage: false,
      // extraPlugins: 'myplugin,anotherplugin',
      removePlugins: 'sourcearea,save,newpage,preview,print,forms',
      toolbarCanCollapse: true,
      toolbarStartupExpanded : false,
      tabSpaces: 4,
      skin: 'bootstrapck',
      height: '400px'
    });

    ck.on('change', function() {
      // Let's access our $rootScope from within jQuery (this)
      _$scope = $('body').scope();
      _$rootScope = _$scope.$root;
      _$scope.$apply(function() {
        _$rootScope.templateNoteEdit.modified = true;
      });
    });
  }

  $scope.$on('insertAttachmentLink', function(ev, args) {
    if(typeof args == "undefined" || typeof args.url == "undefined" || typeof args.mimetype == "undefined") {
      return false;
    }

    var insertHtml = "";

    switch(args.mimetype.match(/^[a-z]+\/*/g)[0]) {
      case "image/":
        insertHtml = '<a href="' + args.url + '" title="' + args.filename + '" target="_blank">' + '<img src="' + args.url + '" alt="' + args.filename + '">' + '</a>';
        break;
      default:
        insertHtml = '<a href="' + args.url + '" title="' + args.filename + '" target="_blank">' + args.filename + '</a>';
    }

    CKEDITOR.instances['content'].insertHtml(insertHtml);
  });

  $rootScope.uploadUrl = paperworkApi + '/notebooks/' + parseInt($routeParams.notebookId) + '/notes/' + parseInt($routeParams.noteId) + '/versions/0/attachments';

  if(typeof $rootScope.notes == "undefined") {
    paperworkNotesService.getNotesInNotebook($rootScope.notebookSelectedId, (function(_notebookId, _noteId) {
      return function() {
        thisController(_notebookId, _noteId);
      }
    })(parseInt($routeParams.notebookId), parseInt($routeParams.noteId)) );
  } else {
    thisController(parseInt($routeParams.notebookId), parseInt($routeParams.noteId));
  }

  $rootScope.navbarMainMenu = false;
  $rootScope.navbarSearchForm = false;
  $rootScope.expandedNoteLayout = true;
});