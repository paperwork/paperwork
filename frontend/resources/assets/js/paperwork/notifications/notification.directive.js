angular.module('paperworkNotes')
    .directive('pwStatusNotification', function ($timeout) {
        var jq = angular.element, timeoutId = null;

        return {
            restrict: 'AE',
            template: '<div class="request_status_feedback" ng-hide="!visible" ng-click="hide()" ng-class="class">{{message}}</div>',
            link: function (scope, elem) {
                var $notificationArea = elem.children().first();

                /**
                 * Hide if clicked.
                 */
                scope.hide = function () {
                    $notificationArea.fadeOut('fast', function() {
                        scope.visible = false;

                        scope.$apply();
                    });

                    $timeout.cancel(timeoutId);
                };

                /**
                 * Respond to the notification event.
                 */
                scope.$on('paperwork.StatusNotificationSent', function (e, type, message) {

                    scope.message = message;

                    //Add type class to notification
                    scope.class = type;

                    // Cancel timeout, if there is one
                    $timeout.cancel(timeoutId);

                    // Display the notification.
                    scope.visible = true;

                    $notificationArea.slideDown(500);

                    // Hide after 5 seconds
                    timeoutId = $timeout(function () {
                        $notificationArea.slideUp(500);

                        scope.visible = false;
                    }, 5000);

                    // If element is removed from DOM, remove timeout
                    elem.bind('$destroy', function () {
                        $timeout.cancel(timeoutId);
                    });

                });
            }
        }
    });
