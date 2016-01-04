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
            .on('error', function (error) {
                console.log(error.toString());
                this.emit('end');
            })
            .pipe(rename(file.output))
            .pipe(gulp.dest(''));
    });
});

gulp.task('js', function(done) {
    var config = require('./webpack.config');

    requirejs.optimize({}, function () {
        done();
    });
});

gulp.task('default', ['css', 'js']);
