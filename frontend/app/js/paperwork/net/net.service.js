angular.module('paperworkNotes').service('NetService',
    function ($rootScope, $http, $location, $window, paperworkApi, StatusNotifications) {
        this.apiGeneric = function (method, url, data, callback) {
            var $opts = {method: method, url: paperworkApi + url, headers: {"X-Requested-With": "XMLHttpRequest"}};
            if (typeof data != "undefined" && data != null) {
                $opts.data = data;
            }
            $http($opts).
                success(function (data, status, headers, config) {
                    if (status == 302) {
                        var header = headers();

                        if (typeof header.location != "undefined" && header.location != null && header.location != "") {
                            $location.path(header.location);

                            return false;
                        }
                    }
                    callback(status, data);
                }).
                error(function (data, status, headers, config) {
                    if (status == 401) {
                        StatusNotifications.sendStatusFeedback("error", "session_expired");
                        //$window.location.reload();
                        return false;
                    }
                    callback(status, data);
                });
        };

        this.apiGet = function (url, callback) {
            this.apiGeneric('GET', url, null, callback);
            if (window.paperworkNative.callbacks.api.get != null) {
                window.paperworkNative.callbacks.api.get(url, null);
            }
        };

        this.apiPost = function (url, data, callback) {
            this.apiGeneric('POST', url, data, callback);
            if (window.paperworkNative.callbacks.api.post != null) {
                window.paperworkNative.callbacks.api.post(url, data);
            }
        };

        this.apiPut = function (url, data, callback) {
            this.apiGeneric('PUT', url, data, callback);
            if (window.paperworkNative.callbacks.api.put != null) {
                window.paperworkNative.callbacks.api.put(url, data);
            }
        };

        this.apiDelete = function (url, callback) {
            this.apiGeneric('DELETE', url, null, callback);
            if (window.paperworkNative.callbacks.api.delete != null) {
                window.paperworkNative.callbacks.api.delete(url, null);
            }
        };
    });
