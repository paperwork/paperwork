angular.module('paperworkNotes').factory('StatusNotifications', ['$timeout', '$rootScope', function ($timeout, $rootScope) {

    var StatusNotificationService = {}, timeoutId = null, jq = jq;

    StatusNotificationService.sendStatusFeedback = function (type, messageKey) {

        var message, notificationDiv, $notificationDiv, notificationDivHeight, $sidebarElements, i,
            $viewParent, $collapseSwitch;

        // Turn string identification into 'real' string
        // All strings needed for this purpose are assumed to be in a separate file
        message = $rootScope.i18n.notifications[messageKey];

        // Wrap element as jQuery element
        $notificationDiv = jq('#status_feedback');

        // Include content in notification
        // jq(notificationDiv.children[0]).text(message);
        $notificationDiv.text(message);

        //Add type class to notification
        $notificationDiv.addClass(type + "_status_feedback");

        // Cancel timeout, if there is one
        $timeout.cancel(timeoutId);

        // Call show() to make sure div display CSS property is correct
        $notificationDiv.show();

        //Remove hidden class from notification
        $notificationDiv.removeClass("hidden");

        // Get height of div to set top margin for following elements
        notificationDivHeight = $notificationDiv.outerHeight();

        // Add top margin to all sidebar elements
        $sidebarElements = jq(".sidebar");

        $sidebarElements.css('margin-top', notificationDivHeight + "px");

        // Add top margin to 'Collapse sidebar' button and paperworkViewParent
        $viewParent = jq("#paperworkViewParent");
        $viewParent.css("margin-top", (notificationDivHeight + "px"));

        $collapseSwitch = jq(".sidebar-collapse-switch");
        $collapseSwitch.first().css("margin-top", (notificationDivHeight + 5 + "px"));

        // Hide after 5 seconds
        timeoutId = $timeout(function () {
            $notificationDiv.slideUp(1500);
            $notificationDiv.addClass("hidden");

            $sidebarElements.css("margin-top", 0);
            $viewParent.css("margin-top", 0);
            $collapseSwitch.css('margin-top', 0);

            $notificationDiv.hide();

        }, 5000);

        // If element is removed from DOM, remove timeout
        $notificationDiv.bind('$destroy', function () {
            $timeout.cancel(timeoutId);
        });

    };

    return StatusNotificationService;

}]);
