angular.module('paperworkNotes').factory('StatusNotifications', ['$timeout', '$rootScope', function($timeout, $rootScope) {
    
    var StatusNotificationService = {};
    
    StatusNotificationService.sendStatusFeedback = function(type, messageKey) {
      
      var timeoutId;
      
      // Turn string identification into 'real' string
      // All strings needed for this purpose are assumed to be in a separate file 
      var message = $rootScope.i18n.notifications[messageKey];
      
      var notificationDiv = document.getElementById("status_feedback");
      
      // Wrap element as jQuery element 
      var notificationDivWrapped = angular.element(notificationDiv);
      
      // Include content in notification 
      angular.element(notificationDiv.children[0]).text(message);      
      //Add type class to notification  
      notificationDivWrapped.addClass(type + "_status_feedback");
      
      //Remove hidden class from notification  
      notificationDivWrapped.removeClass("hidden");
      
      // Get height of div to set top margin for following elements
      var notificationDivHeight = notificationDivWrapped.outerHeight();
      
      // Add top margin to all sidebar elements
      var sidebarElements = document.getElementsByClassName("sidebar");
      for (var i = 0; i < sidebarElements.length; i++) {
          angular.element(sidebarElements[i]).css("margin-top", (notificationDivHeight + "px"));
      }
      
      // Add top margin to 'Collapse sidebar' button and paperworkViewParent
      angular.element(document.getElementById("paperworkViewParent")).css("margin-top", (notificationDivHeight + "px"));
      angular.element(document.getElementsByClassName("sidebar-collapse-switch")[0]).css("margin-top", (notificationDivHeight + 5 + "px"));
      
      // Hide after 5 seconds
      //window.onload = function() {
          timeoutId = $timeout(function() {
              notificationDivWrapped.addClass("hidden");
              
              // Remove top margin from all elements 
              for (i = 0; i < sidebarElements.length; i++) {
                  angular.element(sidebarElements[i]).css("margin-top", (parseInt(sidebarElements[i].style.marginTop, 10) - notificationDivHeight));
              }
              angular.element(document.getElementById("paperworkViewParent")).css("margin-top", (parseInt(document.getElementById("paperworkViewParent").style.marginTop, 10) - notificationDivHeight));
              angular.element(document.getElementsByClassName("sidebar-collapse-switch")[0]).css("margin-top", (parseInt(document.getElementsByClassName("sidebar-collapse-switch")[0].style.marginTop, 10) - (notificationDivHeight + 5)));
      
          }, 15000);
      //};
      
      // If element is removed from DON, remove timeout 
      notificationDivWrapped.bind('$destroy', function() {
          $timeout.cancel(timeoutId);
      });
      
    };
    
    return StatusNotificationService;
    
}]);