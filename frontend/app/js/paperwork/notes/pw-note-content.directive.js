/**
 * Directive that preprocesses content of a note.
 *
 * Currently, it dynamicaly inserts highlight.js directive into content if there any
 * code blocks.
 */
angular.module('paperworkNotes')
    .directive('pwNoteContent', function ($compile) {
        var ae = angular.element;

        return {
            restrict: 'AE',
            scope: {
                content: '='
            },
            link: function (scope, element) {
                // At the very app start, bound note.version.content is empty.
                // So content must be updated later, at the change.
                scope.$watch('content', function () {
                    if (!scope.content) {
                        return;
                    }

                    // Wrap value to not lose it content.
                    var content = ae('<div class="node-content-wrapper">' + scope.content + '</div>'),
                        $code = content.find('code');

                    if ($code.length) {
                        $code.each(function () {
                            var $this = ae(this, content);

                            // Remove outer <pre> as highlightjs creates wrapper <pre>.
                            if ($this.parent().prop('tagName') === 'PRE') {
                                $this.unwrap();
                            }

                            // Replace <code> with div to avoid styles applied to <code>
                            var $codeContainer = ae('<div>', {
                                'class': $this.attr('class'),
                                'language': $this.attr('class').replace(/language-/, ''),
                                'html': $this.html()
                            });

                            // Add highlightjs to the container and set no-escape option.
                            $codeContainer.attr('hljs', '').attr('no-escape', '');

                            $this.replaceWith($codeContainer);
                        });
                    }

                    // Put processed html into element.
                    element.html(content.html());

                    // Compile it to make hljs directive work.
                    $compile(element.contents())(scope);
                });

            }
        }
    });