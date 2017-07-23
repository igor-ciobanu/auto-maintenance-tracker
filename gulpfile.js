// Let's GO!
let gulp = require('gulp'),
    sass = require('gulp-sass'),
    minifyCss = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    sourcemaps = require('gulp-sourcemaps'),
    concatCss = require('gulp-concat-css'),
    runSequence = require('run-sequence'),
    plumber = require('gulp-plumber'),
    rimraf = require('rimraf'); // rimraf directly

    // --------------------------------------------------------
// Proress Node.js error
// --------------------------------------------------------
let onError = function (error) {
    console.log(error);
    this.emit('end');
};

// --------------------------------------------------------
// Compile SASS & Generate Source Maps
// --------------------------------------------------------
gulp.task('sass', function() {
    let sass_paths = [
    	'./resources/styles/**/*.scss'
    ];

    return gulp.src(sass_paths)
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(sourcemaps.init())
        .pipe(sass({errLogToConsole: true}))
        .pipe(sourcemaps.write('.', {includeContent: false}))
        .pipe(gulp.dest('./public/assets/css'));
});

// --------------------------------------------------------
// Prepare view
// --------------------------------------------------------
// For prod
gulp.task('style:prod', function(cb) {
    runSequence(['sass']);
});

// Watch and run compile sass
gulp.task("style:dev", ['sass'], function() {
    gulp.watch("./resources/assets/styles/**/*.*", ['sass'])
});