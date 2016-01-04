var gulp      = require('gulp'),
    stylecow  = require('gulp-stylecow'),
    rename    = require('gulp-rename'),
    requirejs = require('requirejs');

gulp.task('css', function() {
    var config = require('./stylecow.json');

    config.files.forEach(function (file) {
        gulp
            .src(file.input)
            .pipe(stylecow(config))
            .pipe(rename(file.output))
            .pipe(gulp.dest(''));
    });
});

gulp.task('js', function(done) {
    requirejs.optimize({
        appDir: "assets/js",
        baseUrl: '.',
        mainConfigFile : 'assets/js/main.js',
        dir: 'assets/js.dist',
        removeCombined: true,
        modules: [
            {
                name: 'main',
                include: [
                    '../vendor/requirejs/require',
                    './modules/page-loader',
                    './modules/page-loader',
                    './modules/search'
                ]
            }
        ]
    }, function () {
        done();
    });
});

gulp.task('default', ['css', 'js']);
