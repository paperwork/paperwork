paperworkModule.service('paperworkNetService', ['$rootScope', '$http', function($rootScope, $http) {
  this.apiGet = function(url, callback) {
    $http({method: 'GET', url: paperworkApi + url}).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };

  this.apiPost = function(url, data, callback) {
    $http.post(paperworkApi + url, data).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };

  this.apiPut = function(url, data, callback) {
    $http.put(paperworkApi + url, data).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };

  this.apiDelete = function(url, callback) {
    $http.delete(paperworkApi + url).
      success(function(data, status, headers, config) {
        callback(status, data);
      }).
      error(function(data, status, headers, config) {
        callback(status, data);
      });
  };
}]);
