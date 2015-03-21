//  I didn't know a better place to put this in, as it's needed within app.routes.js
var paperworkDbAllId = '00000000-0000-0000-0000-000000000000';

angular.module('paperworkNotes', ['ngRoute', 'ngSanitize', 'ngAnimate', 'angularFileUpload', 'ab-base64', 'ngDraggable', 'ui.bootstrap'])
  .constant('paperworkApi', '/api/v1');
