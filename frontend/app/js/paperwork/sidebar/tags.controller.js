angular.module('paperworkNotes').controller('SidebarTagsController',
    ['$scope', '$rootScope', '$location', '$routeParams', 'NotebooksService', 'paperworkApi', 'NotesService',
        function ($scope, $rootScope, $location, $routeParams, notebooksService, paperworkApi, notesService) {
            $scope.modalTags = [];

            $('#modalManageTags').on('hidden.bs.modal', function (e) {
                $scope.modalTags = [];
                $scope.$apply();    // Because not angular scope
            });
            $('#modalManageTags').on('show.bs.modal', function (e) {
                $scope.modalTags = $rootScope.tags;
            });

            $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
                $('#modalManageTags .tag-line').editable({
                    mode: 'inline',
                    url: function (data) {
                        $.ajax({
                            url: paperworkApi + '/tags/' + data['pk'],
                            data: {
                                title: data['value']
                            },
                            type: 'PUT',
                            error: function (jqXHR) {
                                $('#modalManageTags').find(".tag-line[data-pk='" + data['pk'] + "']").tooltip({
                                    title: jqXHR.responseJSON.errors.title,
                                    trigger: 'manual'
                                }).tooltip('show');
                            },
                            success: function () {
                                notebooksService.getTags();
                                if($rootScope.note) {
                                    notesService.getNoteById(parseInt($rootScope.note.id));
                                }
                            },
                            dataType: 'json'
                        });
                    }
                }).on('shown', function (e, editable) {
                    editable.$element.tooltip('destroy');
                });
            });

            $scope.deleteTag = function (tagId) {
                // show second modal - need changing z-index
                $rootScope.modalMessageBox = {
                    'title': $rootScope.i18n.keywords.delete_tag_question,
                    'content': $rootScope.i18n.keywords.delete_tag_message,
                    'buttons': [
                        {
                            'label':     $rootScope.i18n.keywords.cancel,
                            'isDismiss': true
                        },
                        {
                            'id': 'button-yes',
                            'label': $rootScope.i18n.keywords.yes,
                            'class': 'btn-warning',
                            'click': function () {
                                notebooksService.deleteTag(tagId, function () {
                                    notebooksService.getTags();
                                    if($rootScope.note) {
                                        notesService.getNoteById(parseInt($rootScope.note.id));
                                    }
                                    $('#modalManageTags').find(".tag-line[data-pk='" + tagId + "']").closest('.row').remove();
                                });
                                return true;
                            }
                        }
                    ]
                };
                $('#modalMessageBox').modal('show');
            }
        }]);