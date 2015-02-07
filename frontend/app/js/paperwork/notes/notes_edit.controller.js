angular.module('paperworkNotes').controller('NotesEditController',
  ['$scope', '$rootScope', '$location', '$routeParams', 'NotesService', 'paperworkApi',
    function($scope, $rootScope, $location, $routeParams, notesService, paperworkApi) {
      window.onCkeditChangeFunction = function() {
        // FIXME jQuery un angular is anti-pattern
        // Let's access our $rootScope from within jQuery (this)
        _$scope = $('body').scope();
        _$rootScope = _$scope.$root;
        _$scope.$apply(function() {
          _$rootScope.templateNoteEdit.modified = true;
        });
      };

      window.hasCkeditChangedFunction = function() {
        // Let's access our $rootScope from within jQuery (this)
        _$scope = $('body').scope();
        _$rootScope = _$scope.$root;
        return _$rootScope.templateNoteEdit.modified;
      };

      var thisController = function(notebookId, noteId, _onChangeFunction) {
        $rootScope.noteSelectedId = {'notebookId': notebookId, 'noteId': noteId};
        $rootScope.versionSelectedId = {'notebookId': notebookId, 'noteId': noteId, 'versionId': 0};
        notesService.getNoteById(noteId);
        $rootScope.templateNoteEdit = $rootScope.getNoteByIdLocal(noteId);
        if(typeof $rootScope.templateNoteEdit == "undefined" || $rootScope.templateNoteEdit == null) {
          $rootScope.templateNoteEdit = {};
        }

        notesService.getNoteVersionAttachments($rootScope.getNotebookSelectedId(), ($rootScope.getNoteSelectedId(true)).noteId, $rootScope.getVersionSelectedId(true).versionId,
          function(response) {
            $rootScope.fileList = response;
          });

        if(typeof $rootScope.templateNoteEdit.tags != "undefined" && $rootScope.templateNoteEdit.tags.length > 0) {
          for(var i = 0; i < $rootScope.templateNoteEdit.tags.length; i++) {
            $('input#tags').tagsinput('add', $rootScope.templateNoteEdit.tags[i].title);
          }
        }

        $('input#tags').on('beforeItemAdd', function(ev) {
          // console.log(ev.item);
          // ev.item = ev.item.replace('+', '');
          window.onCkeditChangeFunction();
        }).on('itemRemoved', function() {
          window.onCkeditChangeFunction();
        });

        var ck = CKEDITOR.replace('content', {
          fullPage:               false,
          // extraPlugins: 'myplugin,anotherplugin',
          // removePlugins: 'sourcearea,save,newpage,preview,print,forms',
          toolbarCanCollapse:     true,
          toolbarStartupExpanded: false,
          tabSpaces:              4,
          skin:                   'bootstrapck',
          height:                 '400px',

          autosave_saveOnDestroy:          true,
          autosave_saveDetectionSelectors: "[id*='updateNote']"
        });

        ck.on('change', _onChangeFunction);

        window.onbeforeunloadInfo = $rootScope.i18n.messages.onbeforeunload_info;
        window.onbeforeunload = function() {
          if(window.hasCkeditChangedFunction()) {
            return window.onbeforeunloadInfo;
          }
        };
      };

      var loadedTags = $rootScope.tags;

      var userTags = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local:          loadedTags
      });

      userTags.initialize();

      $('input#tags').tagsinput({
        allowDuplicates: false,
        trimValue:       true,
        freeInput:       true,
        tagClass:        function(item) {
          if(item[0] == '+') {
            return "input-tag-public";
          } else {
            return "input-tag-private";
          }
        },
        typeaheadjs:     {
          name:       'tags',
          displayKey: 'title',
          valueKey:   'title',
          source:     userTags.ttAdapter()
        }
      });
      // This doesn't seem to be working. I might be patching the tagsinput plugin someday to get this working cleanly.
      // $('input#tags').tagsinput('focus');
      // $('input#tags').find('input.tt-input').blur(function() {
      //   var e = jQuery.Event('keydown', { which: 13 });
      //   $(this).trigger(e);
      // });

      $scope.$on('deleteAttachmentLink', function(ev, args) {
        if(typeof args == "undefined" || typeof args.url == "undefined") {
          return false;
        }

        var documentNode = CKEDITOR.instances['content'].document.$,
          elementCollection = documentNode.getElementsByTagName('a');

        var i = elementCollection.length;
        while(i--) {
          var element = elementCollection[i];
          if(element.getAttribute("href") == args.url) {
            element.parentNode.removeChild(element);
          }
        }
      });

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
        notesService.getNotesInNotebook($rootScope.notebookSelectedId, (function(_notebookId, _noteId) {
          return function() {
            thisController(_notebookId, _noteId, function() {
              window.onCkeditChangeFunction();
            });
          }
        })(parseInt($routeParams.notebookId), parseInt($routeParams.noteId)));
      } else {
        thisController(parseInt($routeParams.notebookId), parseInt($routeParams.noteId), function() {
          window.onCkeditChangeFunction();
        });
      }

      $rootScope.navbarMainMenu = false;
      $rootScope.navbarSearchForm = false;
      $rootScope.expandedNoteLayout = true;
    }]);
