angular.module('paperworkNotes').service('NetService',
  ['$rootScope', '$http', '$location', 'paperworkApi',
   function($rootScope, $http, $location, paperworkApi) {
     this.apiGeneric = function(method, url, data, callback) {
       var $opts = {method: method, url: paperworkApi + url};
       if(typeof data != "undefined" && data != null) {
         $opts.data = data;
       }
       $http($opts).
         success(function(data, status, headers, config) {
           if(status == 302) {
             $headrz = headers();
             if(typeof $headrz.location != "undefined" && $headrz.location != null && $headrz.location != "") {
               $location.path($headrz.location);
               return false;
             }
           }
           callback(status, data);
         }).
         error(function(data, status, headers, config) {
           callback(status, data);
         });
     };

     this.apiGet = function(url, callback) {
       this.apiGeneric('GET', url, null, callback);
     };

     this.apiPost = function(url, data, callback) {
       this.apiGeneric('POST', url, data, callback);
     };

     this.apiPut = function(url, data, callback) {
       this.apiGeneric('PUT', url, data, callback);
     };

     this.apiDelete = function(url, callback) {
       this.apiGeneric('DELETE', url, null, callback);
     };
   }]);
