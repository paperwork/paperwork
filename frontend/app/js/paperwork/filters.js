angular.module('paperworkNotes').filter('convertdate', function() {
  return function(value) {
    return (!value) ? '' : value.replace(/ /g, 'T');
  };
});
angular.module('paperworkNotes').filter('unsafe', function($sce) {
    return $sce.trustAsHtml;
});
