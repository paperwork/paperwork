var gulp = require('gulp'),
    less = require('gulp-less'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    livereload = require('gulp-livereload'),
    uglify = require('gulp-uglify'),
    path = require("path"),
    annotate = require('gulp-ng-annotate'),
    jshint = require('gulp-jshint'),
    jshint_stylish = require('jshint-stylish'),
    bower = require('gulp-bower');


var paths = {
    bootstrap: [
        'resources/assets/bower_components/bootstrap/dist/js/bootstrap.js'//,
        //'bootstrap-tree.js'
    ],
    paperwork: [
        'resources/assets/js/paperwork/**/*.js'
    ],
    paperworknative: [
        'resources/assets/js/paperwork-native.js'
    ],
    angular: [
        'resources/assets/bower_components/angular/angular.js',
        'resources/assets/bower_components/angular-resource/angular-resource.js',
        'resources/assets/bower_components/angular-route/angular-route.js',
        //'resources/assets/bower_components/angular-sanitize/angular-sanitize.js',
        'resources/assets/bower_components/angular-animate/angular-animate.js',
        'resources/assets/bower_components/angular-file-upload/angular-file-upload.js',
        'resources/assets/bower_components/angular-utf8-base64/angular-utf8-base64.js',
        'resources/assets/bower_components/angular-ui-bootstrap-bower/ui-bootstrap.js',
        'resources/assets/bower_components/angular-ui-bootstrap-bower/ui-bootstrap-tpls.js',
        'resources/assets/bower_components/ngDraggable/ngDraggable.js',
        'resources/assets/bower_components/angular-loading-bar/src/loading-bar.js',
        'resources/assets/bower_components/textAngular/src/textAngular-sanitize.js',
        'resources/assets/bower_components/angular-highlightjs/angular-highlightjs.min.js'
    ],
    jQuery: [
        'resources/assets/bower_components/jquery/dist/jquery.js',
        'resources/assets/bower_components/jquery-overscroll-fixed/dist/jquery.overscroll.js',
        'resources/assets/bower_components/jquery.scrollTo/jquery.scrollTo.js'
    ],
    tagsinput: [
        'resources/assets/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
        'resources/assets/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput-angular.js',
        'resources/assets/bower_components/typeahead.js/dist/typeahead.bundle.js'
    ],
    libraries: [
        'resources/assets/freqselector.js',
        'resources/assets/mathquill.js',
        'resources/assets/bower_components/retinajs/dist/retina.js',
        'resources/assets/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js',
        //'public/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js'
    ],
    ie9compat: [
        'resources/assets/bower_components/html5shiv/dist/html5shiv.js',
        'resources/assets/bower_components/respond/dest/respond.src.js',
        'resources/assets/bower_components/placeholders/dist/placeholders.min.js'
    ],
    ie11compat: [
        'resources/assets/bower_components/bootstrap3-ie10-viewport-bug-workaround/ie10-viewport-bug-workaround.js'
    ],
    output: {
        js: 'public/js',
        css: 'public/css'
    }
};

gulp.task('compileLessBootstrapTheme', function () {
    gulp
        .src('resources/assets/less/bootstrap/theme.less')
        .pipe(less({
            paths: ['resources/assets/less/bootstrap/']
        }))
        .pipe(rename({
            basename: 'bootstrap-theme.min'
        }))
        .pipe(gulp.dest(paths.output.css))
        .pipe(livereload());
});

gulp.task('compileLessPaperworkThemeV1', function () {
    gulp
        .src('resources/assets/less/paperwork-themes/paperwork-v1/paperwork-v1.less')
        .pipe(less({
            paths: ['resources/assets/less/bootstrap/', 'resources/assets/less/paperwork-themes/paperwork-v1/', 'resources/assets/less/font-awesome/']
        }))
        .pipe(rename({
            basename: 'paperwork-v1.min'
        }))
        .pipe(gulp.dest(path.join(paths.output.css, 'themes')))
        .pipe(livereload());
});

gulp.task('concatLibCSS', function () {
    gulp.src([
        'public/ckeditor/plugins/codesnippet/lib/highlight/styles/default.css',
        'bower_components/angular-loading-bar/src/loading-bar.css'
    ])
        .pipe(concat('libs.css'))
        .pipe(gulp.dest(paths.output.css));
});


gulp.task('compileLessFreqselector', function() {
	gulp
		.src('resources/assets/less/freqselector.less')
		.pipe(less({
			paths: ['resources/assets/less/']
		}))
		.pipe(rename({
			basename: 'freqselector.min'
		}))
		.pipe(gulp.dest(paths.output.css))
		.pipe(livereload());
});

gulp.task('compileLessTypeahead', function () {
    gulp
        .src('resources/assets/less/typeahead.less')
        .pipe(less({
            paths: ['resources/assets/less/']
        }))
        .pipe(rename({
            basename: 'typeahead.min'
        }))
        .pipe(gulp.dest(paths.output.css))
        .pipe(livereload());
});

gulp.task('compileJsBootstrap', function () {
    gulp
        .src(paths.bootstrap)
        .pipe(concat('bootstrap.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsPaperwork', function () {
    gulp
        .src(paths.paperwork)
        .pipe(concat('paperwork.min.js'))
        .pipe(annotate())
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsPaperworkNative', function () {
    gulp
        .src(paths.paperworknative)
        .pipe(concat('paperwork-native.min.js'))
        .pipe(annotate())
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsAngular', function () {
    gulp
        .src(paths.angular)
        .pipe(concat('angular.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsJquery', function () {
    gulp
        .src(paths.jQuery)
        .pipe(concat('jquery.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsTagsinput', function () {
    gulp
        .src(paths.tagsinput)
        .pipe(concat('tagsinput.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsLibraries', function () {
    gulp
        .src(paths.libraries)
        .pipe(concat('libraries.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsLtIe9Compat', function () {
    gulp
        .src(paths.ie9compat)
        .pipe(concat('ltie9compat.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('compileJsLtIe11Compat', function () {
    gulp
        .src(paths.ie11compat)
        .pipe(concat('ltie11compat.min.js'))
        .pipe(gulp.dest(paths.output.js))
        .pipe(livereload());
});

gulp.task('lint', function () {
    gulp
        .src(paths.paperwork)
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish'))
        .pipe(jshint.reporter('fail'));
});

gulp.task('minifyJs', function () {
    gulp
        .src(path.join(paths.output.js, '*.js'))
        .pipe(uglify())
        .pipe(gulp.dest(paths.output.js));
});

gulp.task('bower', function () {
    return bower().pipe(gulp.dest('js'));
});

gulp.task('bower-update', function () {
    return bower({cmd: 'update'}).pipe(gulp.dest('js'));
});

gulp.task('less', ['compileLessBootstrapTheme', 'compileLessPaperworkThemeV1', 'compileLessFreqselector', 'compileLessTypeahead']);
gulp.task('js', ['compileJsBootstrap', 'compileJsPaperwork', 'compileJsPaperworkNative', 'compileJsAngular', 'compileJsJquery', 'compileJsTagsinput', 'compileJsLibraries', 'compileJsLtIe9Compat', 'compileJsLtIe11Compat']);

gulp.task('default', ['less', 'lint', 'js', 'concatLibCSS']);
gulp.task('prod', ['default', 'minifyJs']);

gulp.task('watch', function () {
    livereload.listen();
    gulp.watch('resources/assets/less/*.less', ['less']);
    gulp.watch('resources/assets/less/bootstrap/*.less', ['less']);
    gulp.watch('resources/assets/less/font-fontawesome/*.less', ['less']);
    gulp.watch('resources/assets/less/paperwork-themes/paperwork-v1/*.less', ['less']);
    gulp.watch('**/*.js', ['js']);
    gulp.watch('bootstrap/*.js', ['compileJsBootstrap']);
    gulp.watch('paperwork/*.js', ['compileJsPaperwork']);
});
