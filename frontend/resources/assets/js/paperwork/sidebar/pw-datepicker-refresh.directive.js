angular.module('paperworkNotes')
  .directive('pwDatepickerRefresh', function() {
    var noop = function() {};
    var refresh = function(dpCtrl) {
      return function() {
        dpCtrl.refreshView();
      };
    };

    return {
      require: 'datepicker',
      link:    function(scope, elem, attrs, dpCtrl) {
        var refreshPromise = scope[attrs.pwDatepickerRefresh];
        refreshPromise.then(noop, noop, refresh(dpCtrl));
      }
    };
  });
