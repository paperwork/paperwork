angular.module('paperworkNotes').controller('SettingsController',
  function ($scope, $rootScope, $http, $sce) {
    $scope.tabs = {
      'client': {
        isLoaded: false,
        loadInProcess: false,
        content: ''
      }
    };

    $scope.getTabContent = function (tabName) {

      if (typeof $scope.tabs[tabName] == 'undefined' || $scope.tabs[tabName].isLoaded || $scope.tabs[tabName].loadInProcess) {
        return
      }

      var $opts = {method: 'GET', url: 'templates/' + tabName};
      $scope.tabs[tabName].loadInProcess = true;
      $http($opts).
        success(function (data, status, headers, config) {
          $scope.tabs[tabName].content = $sce.trustAsHtml(data);
          $scope.tabs[tabName].isLoaded = true;
          $scope.tabs[tabName].loadInProcess = false;
        }).
        error(function (data, status, headers, config) {

        });
    };
  });
