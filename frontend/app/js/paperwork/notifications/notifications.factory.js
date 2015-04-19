angular.module('paperworkNotes').factory('StatusNotifications', function ($timeout, $rootScope) {

    var StatusNotificationService = {}, timeoutId = null, jq = jq;

    StatusNotificationService.sendStatusFeedback = function (type, messageKey) {
        var message;

        // Get translated key and broadcast event to notifier.
        message = $rootScope.i18n.notifications[messageKey];

        $rootScope.$broadcast('paperwork.StatusNotificationSent', type, message);

    };

    return StatusNotificationService;

});
