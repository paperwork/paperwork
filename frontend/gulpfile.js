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
        'app/js/bower_components/bootstrap/dist/js/bootstrap.js'//,
        //'app/js/bootstrap-tree.js'
    ],
    paperwork: [
        'app/js/paperwork/**/*.js'
    ],
    paperworknative: [
        'app/js/paperwork-native.js'
    ],
    angular: [
        'app/js/bower_components/angular/angular.js',
        'app/js/bower_components/angular-resource/angular-resource.js',
        'app/js/bower_components/angular-route/angular-route.js',
        //'app/js/bower_components/angular-sanitize/angular-sanitize.js',
        'app/js/bower_components/angular-animate/angular-animate.js',
        'app/js/bower_components/angular-file-upload/angular-file-upload.js',
        'app/js/bower_components/angular-utf8-base64/angular-utf8-base64.js',
        'app/js/bower_components/angular-ui-bootstrap-bower/ui-bootstrap.js',
        'app/js/bower_components/angular-ui-bootstrap-bower/ui-bootstrap-tpls.js',
        'app/js/bower_components/ngDraggable/ngDraggable.js',
        'app/js/bower_components/angular-loading-bar/src/loading-bar.js',
        'app/js/bower_components/textAngular/src/textAngular-sanitize.js',
        'app/js/bower_components/angular-highlightjs/angular-highlightjs.min.js'
    ],
    jQuery: [
        'app/js/bower_components/jquery/dist/jquery.js',
        'app/js/bower_components/jquery-overscroll-fixed/dist/jquery.overscroll.js',
        'app/js/bower_components/jquery.scrollTo/jquery.scrollTo.js'
    ],
    tagsinput: [
        'app/js/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.js',
        'app/js/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput-angular.js',
        'app/js/bower_components/typeahead.js/dist/typeahead.bundle.js'
    ],
    libraries: [
        'app/js/freqselector.js',
        'app/js/mathquill.js',
        'app/js/bower_components/retinajs/dist/retina.js',
        'public/ckeditor/plugins/codesnippet/lib/highlight/highlight.pack.js'
    ],
    ie9compat: [
        'app/js/bower_components/html5shiv/dist/html5shiv.js',
        'app/js/bower_components/respond/dest/respond.src.js',
        'app/js/bower_components/placeholders/dist/placeholders.min.js'
    ],
    ie11compat: [
        'app/js/bower_components/bootstrap3-ie10-viewport-bug-workaround/ie10-viewport-bug-workaround.js'
    ],
    output: {
        js: 'public/js',
        css: 'public/css'
    }
};

gulp.task('compileLessBootstrapTheme', function () {
    gulp
        .src('app/less/bootstrap/theme.less')
        .pipe(less({
            paths: ['app/less/bootstrap/']
        }))
        .pipe(rename({
            basename: 'bootstrap-theme.min'
        }))
        .pipe(gulp.dest(paths.output.css))
        .pipe(livereload());
});

gulp.task('compileLessPaperworkThemeV1', function () {
    gulp
        .src('app/less/paperwork-themes/paperwork-v1/paperwork-v1.less')
        .pipe(less({
            paths: ['app/less/bootstrap/', 'app/less/paperwork-themes/paperwork-v1/', 'app/less/font-awesome/']
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
        'app/js/bower_components/angular-loading-bar/src/loading-bar.css'
    ])
        .pipe(concat('libs.css'))
        .pipe(gulp.dest(paths.output.css));
});


gulp.task('compileLessFreqselector', function() {
	gulp
		.src('app/less/freqselector.less')
		.pipe(less({
			paths: ['app/less/']
		}))
		.pipe(rename({
			basename: 'freqselector.min'
		}))
		.pipe(gulp.dest(paths.output.css))
		.pipe(livereload());
});

gulp.task('compileLessTypeahead', function () {
    gulp
        .src('app/less/typeahead.less')
        .pipe(less({
            paths: ['app/less/']
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
    gulp.watch('app/less/*.less', ['less']);
    gulp.watch('app/less/bootstrap/*.less', ['less']);
    gulp.watch('app/less/font-fontawesome/*.less', ['less']);
    gulp.watch('app/less/paperwork-themes/paperwork-v1/*.less', ['less']);
    gulp.watch('app/js/**/*.js', ['js']);
    gulp.watch('app/js/bootstrap/*.js', ['compileJsBootstrap']);
    gulp.watch('app/js/paperwork/*.js', ['compileJsPaperwork']);
});
