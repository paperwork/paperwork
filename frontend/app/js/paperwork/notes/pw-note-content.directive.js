angular.module('paperworkNotes')
    .directive('pwNoteContent', function ($compile) {
        return {
            restrict: 'AE',
            scope: {
                content: '='
            },
            link: function (scope, element) {
                scope.$watch('content', function () {
                    if (scope.content) {
                        var content = angular.element(scope.content), code = content.find('code');

                        code.each(function () {
                            var $this = angular.element(this, content);

                            $this.replaceWith(
                                angular.element('<div>', {
                                    'class': $this.attr('class'),
                                    'language': $this.attr('class').replace(/language-/, ''),
                                    'hljs': true,
                                    'no-escape': true,
                                    'html': $this.html()
                                })
                            );
                        });

                        element.html(content.html());

                        $compile(element.contents())(scope);
                    }
                });

            }
        }
    });