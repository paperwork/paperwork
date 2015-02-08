angular.module('paperworkNotes').controller('SidebarTagsController',
    ['$scope', '$rootScope', '$location', '$routeParams', 'NotebooksService', 'paperworkApi', '$timeout',
        function ($scope, $rootScope, $location, $routeParams, notebooksService, paperworkApi, $timeout) {
            $scope.modalTags = [];

            $('#modalManageTags').on('hidden.bs.modal', function (e) {
                $scope.modalTags = [];
                $scope.$apply();    // TODO: need think how to get rid of this, but we need rebuild lines on next show
            });
            $('#modalManageTags').on('show.bs.modal', function (e) {
                $scope.modalTags = $rootScope.tags;
                // TODO: rewtite it without timeout. Need wait until DOM will rebuilt
                $timeout(function () {
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
                                },
                                dataType: 'json'
                            });
                        }
                    }).on('shown', function (e, editable) {
                        editable.$element.tooltip('destroy');
                    });
                }, 0);
            });

            $scope.deleteTag = function (tagId) {
                // show second modal - need changing z-index
                $rootScope.modalMessageBox = {
                    'title': $rootScope.i18n.keywords.delete_tag_question,
                    'content': $rootScope.i18n.keywords.delete_tag_message,
                    'buttons': [
                        {
                            'label': $rootScope.i18n.keywords.cancel,
                            'isDismiss': true,
                            'id': 'button-cancel',
                            'click': function () {
                                $('#modalMessageBox').css('z-index', '');
                            }
                        },
                        {
                            'id': 'button-yes',
                            'label': $rootScope.i18n.keywords.yes,
                            'class': 'btn-warning',
                            'click': function () {
                                notebooksService.deleteTag(tagId, function () {
                                    notebooksService.getTags();
                                    $('#modalManageTags').find(".tag-line[data-pk='" + tagId + "']").closest('.row').remove();
                                });
                                $('#modalMessageBox').css('z-index', '');
                                return true;
                            }
                        }
                    ]
                };
                $('#modalMessageBox').modal('show').css('z-index', 10000);
            }
        }]);