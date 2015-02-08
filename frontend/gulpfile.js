var gulp = require('gulp');
var less = require('gulp-less');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var livereload = require('gulp-livereload');
var uglify = require('gulp-uglify');
var path = require("path");

var paths = {
	bootstrap: [
		'app/js/bootstrap/transition.js',
		'app/js/bootstrap/collapse.js',
		'app/js/bootstrap/dropdown.js',
		'app/js/bootstrap/modal.js',
		'app/js/bootstrap/tab.js',
		'app/js/bootstrap/tooltip.js',
		'app/js/bootstrap/popover.js',
		'app/js/bootstrap-tree.js'
	],
	paperwork: [
		'app/js/paperwork/**/*.js'
	],
	angular: [
		'app/js/angular.js',
		'app/js/angular-resource.js',
		'app/js/angular-route.js',
		'app/js/angular-sanitize.js',
		'app/js/angular-animate.js',
		'app/js/angular-file-upload.js',
		'app/js/angular-utf8-base64.js'
	],
	jQuery: [
		'app/js/jquery.js',
		'app/js/jquery.overscroll.js',
		'app/js/jquery.scrollTo.js'
	],
	tagsinput: [
		'app/js/bootstrap-tagsinput.js',
		'app/js/bootstrap-tagsinput-angular.js',
		'app/js/typeahead.js'
	],
	libraries: [
		'app/js/freqselector.js',
		'app/js/retina.js'
	],
	ie9compat: [
		'app/js/html5shiv.js',
		'app/js/respond.js'
	],
	ie11compat: [
		'app/js/ie10-viewport-bug-workaround.js'
	],
	output: {
		js: 'public/js',
		css: 'public/css'
	}
};

gulp.task('compileLessBootstrapTheme', function() {
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

gulp.task('compileLessPaperworkThemeV1', function() {
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

gulp.task('compileLessTypeahead', function() {
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

gulp.task('compileJsBootstrap', function() {
	gulp
		.src(paths.bootstrap)
		.pipe(concat('bootstrap.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsPaperwork', function() {
	gulp
		.src(paths.paperwork)
		.pipe(concat('paperwork.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsAngular', function() {
	gulp
		.src(paths.angular)
		.pipe(concat('angular.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsJquery', function() {
	gulp
		.src(paths.jQuery)
		.pipe(concat('jquery.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsTagsinput', function() {
	gulp
		.src(paths.tagsinput)
		.pipe(concat('tagsinput.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsLibraries', function() {
	gulp
		.src(paths.libraries)
		.pipe(concat('libraries.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsLtIe9Compat', function() {
	gulp
		.src(paths.ie9compat)
		.pipe(concat('ltie9compat.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('compileJsLtIe11Compat', function() {
	gulp
		.src(paths.ie11compat)
		.pipe(concat('ltie11compat.min.js'))
		.pipe(gulp.dest(paths.output.js))
		.pipe(livereload());
});

gulp.task('minifyJs', function() {
	gulp
		.src(path.join(paths.output.js, '*.js'))
		.pipe(uglify())
		.pipe(gulp.dest(paths.output.js));
});

gulp.task('less', ['compileLessBootstrapTheme', 'compileLessPaperworkThemeV1', 'compileLessFreqselector', 'compileLessTypeahead']);
gulp.task('js', ['compileJsBootstrap', 'compileJsPaperwork', 'compileJsAngular', 'compileJsJquery', 'compileJsTagsinput', 'compileJsLibraries', 'compileJsLtIe9Compat', 'compileJsLtIe11Compat']);

gulp.task('default', ['less', 'js']);
gulp.task('prod', ['default', 'minifyJs']);

gulp.task('watch', function() {
  livereload.listen();
  gulp.watch('app/less/*.less', ['less']);
  gulp.watch('app/less/bootstrap/*.less', ['less']);
  gulp.watch('app/less/font-fontawesome/*.less', ['less']);
  gulp.watch('app/less/paperwork-themes/paperwork-v1/*.less', ['less']);
  gulp.watch('app/js/*.js', ['js']);
  gulp.watch('app/js/bootstrap/*.js', ['compileJsBootstrap']);
  gulp.watch('app/js/paperwork/*.js', ['compileJsPaperwork']);
});
