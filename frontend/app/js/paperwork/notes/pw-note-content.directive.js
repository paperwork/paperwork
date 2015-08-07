angular.module('paperworkNotes')
    .directive('pwNoteContent', function ($compile) {
        var ae = angular.element;

        return {
            restrict: 'AE',
            scope: {
                content: '='
            },
            link: function (scope, element) {
                scope.$watch('content', function () {
                    if (scope.content) {
                        var content = ae('<div class="node-content-wrapper">' + scope.content + '</div>'),
                            code = content.find('code');

                        code.each(function () {
                            var $this = ae(this, content);

                            if ($this.parent().prop('tagName') === 'PRE') {
                                $this.unwrap();
                            }

                            var $codeContainer = ae('<div>', {
                                'class': $this.attr('class'),
                                'language': $this.attr('class').replace(/language-/, ''),
                                'html': $this.html()
                            });

                            $codeContainer.attr('hljs', '').attr('no-escape', '');

                            $this.replaceWith($codeContainer);
                        });

                        element.html(content.html());

                        $compile(element.contents())(scope);
                    }
                });

            }
        }
    });