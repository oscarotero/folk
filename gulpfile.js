'use strict';

const gulp      = require('gulp'),
      stylecow  = require('gulp-stylecow'),
      rename    = require('gulp-rename'),
      path      = require('path'),
      requirejs = require('requirejs'),
      del       = require('del'),
      fs        = require('fs'),
      modernizr = require('modernizr'),
      bower     = path.join(__dirname, 'bower_components');

gulp.task('css', function() {
    let config = require('./stylecow.json');

    config.files.forEach(function (file) {
        gulp
            .src(file.input)
            .pipe(stylecow(config))
            .pipe(rename(file.output))
            .pipe(gulp.dest(''));
    });
});

gulp.task('js', ['js:vendor', 'js:modernizr']);

gulp.task('js:vendor', function(done) {
    del.sync(path.join('assets/js/vendor'));

    [
        ['ckeditor', '**/*'],
        ['codemirror', '**/*'],
        ['handsontable', 'dist/**/*'],
        ['jquery', 'dist/jquery.js'],
        ['jquery-lazyscript', '*.js'],
        ['magnific-popup', 'dist/*.js'],
        ['microplugin', 'src/**/*'],
        ['requirejs', '*.js'],
        ['selectize', 'dist/js/*'],
        ['sifter', '*.js'],
        ['typeahead.js', 'dist/**/*'],
        ['datetimepicker', 'build/*.js'],
        ['jquery-mousewheel', '*.js'],
        ['php-date-formatter', 'js/*.js'],
        ['notifyjs', 'dist/*.js'],
        ['gettext-translator', 'src/*.js'],
        ['sprintf', 'src/sprintf.js'],
        ['requirejs-plugins', 'src/*.js'],
        ['requirejs-plugins', 'lib/text.js'],
        ['CKEditor-WordCount-Plugin', 'wordcount/**', 'ckeditor/plugins/wordcount'],
    ].forEach(function (module) {
        let dest = module[2] || module[0];

        gulp
            .src(path.join(bower, module[0], module[1]))
            .pipe(gulp.dest(path.join('assets/js/vendor', dest)))
    });
});

gulp.task('js:modernizr', function(callback) {
    modernizr.build({
        'options': [
            'setClasses'
        ],
        'feature-detects': [
            'inputtypes',
        ]
    }, function (result) {
        fs.writeFile('assets/js/modernizr.js', result, function(error) {
            callback(error);
        });
    });
});

gulp.task('img', function (done) {
    del.sync(path.join('assets/icons'));

    gulp
        .src(path.join(bower, 'mdi-svg/svg/*.svg'))
        .pipe(gulp.dest('assets/icons', done))
        .on('end', done);
});

gulp.task('default', ['css', 'js', 'img']);
