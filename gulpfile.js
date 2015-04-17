var gulp = require('gulp');
var chmod = require('gulp-chmod');
var bower = require('gulp-bower');
var plumber = require('gulp-plumber');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var size = require('gulp-size');
var minifycss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var imagemin = require('gulp-imagemin');
var sourcemaps = require('gulp-sourcemaps');

var paths = {
    js: {},
    css: {},
    images: {},
    fonts: {},
    compass: {}
};

var dest = {
    fonts: 'web/fonts/',
    css: 'web/css/',
    js: 'web/js/',
    images: 'web/img/'
};

gulp.task('bower', function() {
    return bower()
        .pipe(chmod(644))
        .pipe(gulp.dest('vendor/components/'));
});

paths.css = [
    'vendor/components/bootstrap/dist/css/bootstrap.css',
    'vendor/components/fontawesome/css/font-awesome.css',
    'vendor/components/admin-lte/dist/css/AdminLTE.css',
    'vendor/components/admin-lte/dist/css//skins/skin-red.css',
    'app/Resources/public/css/**/*.css'
];
gulp.task('css', ['bower'], function() {
    return gulp.src(paths.css)
        .pipe(sourcemaps.init())
            .pipe(concat('app.css'))
            .pipe(gulp.dest(dest.css))
            .pipe(minifycss())
            .pipe(rename('app.min.css'))
        .pipe(sourcemaps.write('./'))
        .pipe(chmod(644))
        .pipe(gulp.dest(dest.css))
        .pipe(size({showFiles: true, title: 'css'}));
});

paths.js = [
    'vendor/components/jquery/dist/jquery.js',
    'vendor/components/bootstrap/dist/js/bootstrap.js',
    'vendor/components/admin-lte/plugins/slimScroll/jquery.slimscroll.js',
    'vendor/components/admin-lte/dist/js/app.js',
    'vendor/components/highcharts/highcharts.js',
    'app/Resources/public/js/**/*.js'
];
gulp.task('js', ['bower'], function() {
    return gulp.src(paths.js)
        .pipe(sourcemaps.init())
            .pipe(concat('app.js'))
            .pipe(gulp.dest(dest.js))
            .pipe(uglify())
            .pipe(rename('app.min.js'))
        .pipe(sourcemaps.write('./'))
        .pipe(chmod(644))
        .pipe(gulp.dest(dest.js))
        .pipe(size({showFiles: true, title: 'js'}));
});

paths.fonts = [
    'vendor/components/bootstrap/dist/fonts/**.*',
    'vendor/components/fontawesome/fonts/**.*',
    'app/Resources/public/fonts/**.*'
];
gulp.task('fonts', ['bower'], function() {
    return gulp.src(paths.fonts)
        .pipe(chmod(644))
        .pipe(gulp.dest(dest.fonts))
        .pipe(size({showFiles: true, title: 'fonts'}));
});

paths.images = [
    'app/Resources/public/images/*'
];
gulp.task('images', function() {
    return gulp.src(paths.images)
        .pipe(plumber())
        .pipe(imagemin({
            progressive: true,
            interlaced: true
        }))
        .pipe(chmod(644))
        .pipe(gulp.dest(dest.images))
        .pipe(size({showFiles: true, title: 'images'}));
});

gulp.task('app', ['js', 'css', 'fonts', 'images'], function() {});

gulp.task('watch', ['app'], function() {
    gulp.watch(paths.js, ['js']);
    gulp.watch(paths.css, ['css']);
    gulp.watch(paths.fonts, ['fonts']);
    gulp.watch(paths.images, ['images']);
});

gulp.task('default', ['app'], function() {});