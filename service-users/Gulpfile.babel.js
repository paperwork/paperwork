const gulp = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint');
const rimraf = require('rimraf');
const run = require('run-sequence');
const watch = require('gulp-watch');
const server = require('gulp-develop-server');
const gulpDocumentation = require('gulp-documentation');
const shell = require('gulp-shell');
const nodePath = require('path');
const ava = require('gulp-ava');
const istanbul = require('gulp-istanbul');
const ispartaInstrumenter = require('isparta').Instrumenter;
const dotenv = require('dotenv');
dotenv.config();

const CONFIG = {
    server: {
        js: {
            src: './src/**/*.js',
            dst: './compiled'
        }
    },
    tests: {
        js: {
            trgt: './tests/**/*.js'
        }
    },
    documentation: {
        js: {
            dst: './documentation'
        }
    }
}

function handleError(err) {
    console.log(err.toString());
    this.emit('end');
}

gulp.task('default', cb => {
    run('lint', 'flowtype', 'build', 'server:start', 'watch', cb);
});

gulp.task('start', cb => {
    run('server:live');
});

gulp.task('debug', cb => {
    run('server:debug');
});

gulp.task('build', cb => {
    run('clean', 'babel', cb);
});

gulp.task('clean', cb => {
    rimraf(CONFIG.server.js.dst, cb);
});

/**
 * ESLint
 */
gulp.task('lint', cb => {
    return gulp.src([CONFIG.server.js.src,'!node_modules/**'])
        .on('error', handleError)
        .pipe(eslint())
        .pipe(eslint.format())
        .pipe(eslint.failAfterError());
});

/**
 * Flow
 */
gulp.task('flowtype', shell.task(['npm run flow check --show-all-errors']));

/**
 * Babel
 */
gulp.task('babel', cb => {
    gulp.src([CONFIG.server.js.src])
        .pipe(sourcemaps.init())
        .pipe(babel({
            presets: [],
            plugins: ['transform-flow-strip-types']
        }))
        .on('error', handleError)
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(CONFIG.server.js.dst))
        .on('end', cb);
});

/**
 * Tests
 */
gulp.task('test', cb => {
    run('test:pre', 'test:run', cb);
});

gulp.task('test:pre', cb => {
    gulp.src([CONFIG.server.js.src, '!tests/**/*'])
    .on('error', handleError)
    //.pipe(istanbul({
    //    'instrumenter': ispartaInstrumenter,
    //    'includeUntested': true
    //}))
    .pipe(istanbul.hookRequire())
    .pipe(gulp.dest('tests/.tmp/'))
    .on('end', cb);
});

gulp.task('test:run', cb => {
    process.env.NODE_BASE_PATH = process.cwd();
    process.env.LOG_LEVEL = 60;
    gulp.src(CONFIG.tests.js.trgt)
    .pipe(ava({ verbose: true, serial: true }))
    //.pipe(istanbul.writeReports())
    .on('end', cb);
});

/**
 * Documentation
 */
gulp.task('doc', cb => {
    run('docs', cb);
});

gulp.task('docs', cb => {
    return gulp.src(CONFIG.server.js.src)
    .pipe(gulpDocumentation('md', {}, {
        'name': 'Paperwork'
    }))
    .pipe(gulp.dest(CONFIG.documentation.js.dst));
});

/**
 * Server (live)
 */
gulp.task('server:live', shell.task(['node --harmony ./compiled/Server.js']));

/**
 * Server (debug)
 */
gulp.task('server:debug', shell.task(['node --harmony --inspect ./compiled/Server.js']));

/**
 * Server Start
 */
gulp.task('server:start', () => {
    server.listen({
        execArgv: ['--harmony'],
        path: './compiled/Server.js'
    });
});

/**
 * Gulp Watch
 */
gulp.task('watch', () => {
    return watch(['package.json', CONFIG.server.js.src], (file) => {
        console.log("File changed:" + file.path);

        if(nodePath.basename(file.path) === 'package.json') {
            process.exit(0);
        } else if(file.path.match(/(\/tests\/)/i)) {
            console.log('Killing server...');
            server.kill();
            console.log('Running tests...');
            run('lint', 'flowtype', 'build', 'test', cb => {
                console.log('Tests ran.');
                server.restart();
            });
        } else {
            run('lint', 'flowtype', 'build', () => {
                server.restart();
            });
        }
    });
});

