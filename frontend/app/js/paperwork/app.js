(function () {
    'use strict';

    var path = document.querySelector('[src*="paperwork.min.js"]')
        .src.split('/')
        .filter(function(a) { return a !== ''; })
        .slice(2), prefix = '';

    // Suspect subfolder.
    if (path[0] !== 'js') {
        prefix = '/' + path.slice(0, path.indexOf('js')).join('/');
    }

    /**
     * Defines paperwork module and its constants.
     */
    angular.module('paperworkNotes', ['ngRoute', 'ngSanitize', 'ngAnimate', 'angularFileUpload', 'ab-base64', 'ngDraggable', 'ui.bootstrap', 'angular-loading-bar', 'hljs'])
        .constant('paperworkApi', prefix + '/api/v1')
        .constant('paperworkDbAllId', '00000000-0000-0000-0000-000000000000')
        .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
            cfpLoadingBarProvider.includeSpinner = false;
        }])
        .config(function (hljsServiceProvider) {
            hljsServiceProvider.setOptions({
                tabReplace: '    '
            });
        })
    ;
}());
