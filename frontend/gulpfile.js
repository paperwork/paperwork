var gulp = require('gulp');
var less = require('gulp-less');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var livereload = require('gulp-livereload');

gulp.task('compileLessBootstrapTheme', function() {
	gulp
		.src('app/less/bootstrap/theme.less')
		.pipe(less({
			paths: ['app/less/bootstrap/']
		}))
		.pipe(rename({
			basename: 'bootstrap-theme.min'
		}))
		.pipe(gulp.dest('public/css'))
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
		.pipe(gulp.dest('public/css/themes'))
		.pipe(livereload());
});

gulp.task('compileLessFontLato', function() {
	gulp
		.src('app/less/font-lato.less')
		.pipe(less({
			paths: ['app/less/']
		}))
		.pipe(rename({
			basename: 'font-lato'
		}))
		.pipe(gulp.dest('public/css'))
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
		.pipe(gulp.dest('public/css'))
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
		.pipe(gulp.dest('public/css'))
		.pipe(livereload());
});

gulp.task('compileJsBootstrap', function() {
	gulp
		.src([
			'app/js/bootstrap/transition.js',
			'app/js/bootstrap/collapse.js',
			'app/js/bootstrap/dropdown.js',
			'app/js/bootstrap/modal.js',
			'app/js/bootstrap/tab.js',
			'app/js/bootstrap/tooltip.js',
			'app/js/bootstrap/popover.js',
			'app/js/bootstrap-tree.js'
		])
		.pipe(concat('bootstrap.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsPaperwork', function() {
	gulp
		.src([
			'app/js/paperwork/paperwork.js',
			'app/js/paperwork/paperworkFilters.js',
			'app/js/paperwork/paperworkRoutes.js',
			'app/js/paperwork/paperworkNetService.js',
			'app/js/paperwork/paperworkNotebooksService.js',
			'app/js/paperwork/paperworkNotesService.js',
			'app/js/paperwork/paperworkVersionsService.js',
			'app/js/paperwork/paperworkMessageBoxService.js',
			'app/js/paperwork/paperworkConstructorController.js',
			'app/js/paperwork/paperworkDefaultController.js',
			'app/js/paperwork/paperworkNotesAllController.js',
			'app/js/paperwork/paperworkNotesShowController.js',
			'app/js/paperwork/paperworkNotesEditController.js',
			'app/js/paperwork/paperworkNotesListController.js',
			'app/js/paperwork/paperworkSidebarNotebooksController.js',
			'app/js/paperwork/paperworkSidebarNotesController.js',
			'app/js/paperwork/paperworkVersionsController.js',
			'app/js/paperwork/paperworkSearchController.js',
			'app/js/paperwork/paperworkViewController.js',
			'app/js/paperwork/paperworkFileUploadController.js',
			'app/js/paperwork/paperworkMessageBoxController.js',
			'app/js/paperwork/paperworkWaybackController.js',
			'app/js/paperwork/paperworkFourOhFourController.js'
		])
		.pipe(concat('paperwork.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsAngular', function() {
	gulp
		.src([
			'app/js/angular.js',
			'app/js/angular-resource.js',
			'app/js/angular-route.js',
			'app/js/angular-sanitize.js',
			'app/js/angular-animate.js',
			'app/js/angular-file-upload.js',
			'app/js/angular-utf8-base64.js'
		])
		.pipe(concat('angular.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsJquery', function() {
	gulp
		.src([
			'app/js/jquery.js',
			'app/js/jquery.overscroll.js',
			'app/js/jquery.scrollTo.js'
		])
		.pipe(concat('jquery.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsTagsinput', function() {
	gulp
		.src([
			'app/js/bootstrap-tagsinput.js',
			'app/js/bootstrap-tagsinput-angular.js',
			'app/js/typeahead.js'
		])
		.pipe(concat('tagsinput.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsLibraries', function() {
	gulp
		.src([
			'app/js/freqselector.js',
			'app/js/retina.js'
		])
		.pipe(concat('libraries.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsLtIe9Compat', function() {
	gulp
		.src([
			'app/js/html5shiv.js',
			'app/js/respond.js'
		])
		.pipe(concat('ltie9compat.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('compileJsLtIe11Compat', function() {
	gulp
		.src([
			'app/js/ie10-viewport-bug-workaround.js'
		])
		.pipe(concat('ltie11compat.min.js'))
		.pipe(gulp.dest('public/js'))
		.pipe(livereload());
});

gulp.task('less', ['compileLessBootstrapTheme', 'compileLessPaperworkThemeV1', 'compileLessFontLato', 'compileLessFreqselector', 'compileLessTypeahead']);
gulp.task('js', ['compileJsBootstrap', 'compileJsPaperwork', 'compileJsAngular', 'compileJsJquery', 'compileJsTagsinput', 'compileJsLibraries', 'compileJsLtIe9Compat', 'compileJsLtIe11Compat']);

gulp.task('default', ['less', 'js']);

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
