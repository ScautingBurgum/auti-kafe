// Load plugins
const autoprefixer = require("gulp-autoprefixer");
const browsersync = require("browser-sync");
const cleanCSS = require("gulp-clean-css");
const gulp = require("gulp");
const header = require("gulp-header");
const plumber = require("gulp-plumber");
const rename = require("gulp-rename");
const sass = require("gulp-sass");
const pkg = require('./package.json');
const connectPHP = require('gulp-connect-php');
// const livereload = require('gulp-livereload');

// Set the banner content
const banner = ['/*!\n',
  ' * Start Bootstrap - <%= pkg.title %> v<%= pkg.version %> (<%= pkg.homepage %>)\n',
  ' * Copyright 2013-' + (new Date()).getFullYear(), ' <%= pkg.author %>\n',
  ' * Licensed under <%= pkg.license %> (https://github.com/BlackrockDigital/<%= pkg.name %>/blob/master/LICENSE)\n',
  ' */\n',
  '\n'
].join('');

// Copy third party libraries from /node_modules into /vendor
gulp.task('vendor', function(cb) {

  // Bootstrap
  gulp.src([
      './node_modules/bootstrap/dist/**/*',
      '!./node_modules/bootstrap/dist/css/bootstrap-grid*',
      '!./node_modules/bootstrap/dist/css/bootstrap-reboot*'
    ])
    .pipe(gulp.dest('./dist/vendor/bootstrap'))

  // jQuery
  gulp.src([
      './node_modules/jquery/dist/*',
      '!./node_modules/jquery/dist/core.js'
    ])
    .pipe(gulp.dest('./dist/vendor/jquery'))

  cb();

});

// CSS task
function css() {
  return gulp
    .src("./scss/*.scss")
    .pipe(plumber())
    .pipe(sass({
      outputStyle: "expanded"
    }))
    .on("error", sass.logError)
    .pipe(autoprefixer({
      browsers: ['last 2 versions'],
      cascade: false
    }))
    .pipe(header(banner, {
      pkg: pkg
    }))
    .pipe(gulp.dest("./dist/css/"))
    .pipe(rename({
      suffix: ".min"
    }))
    .pipe(cleanCSS())
    .pipe(gulp.dest("./dist/css/"))
    .pipe(browsersync.stream());
}

// Tasks
gulp.task("css", css);

// BrowserSync
function browserSyncStart(done) {
  // browsersync.init({
  //   server: {
  //     baseDir: "./dist/"
  //   }
  // });
  connectPHP.server({
    hostname: '0.0.0.0',
    bin: 'C:/xampp/php/php.exe',
    ini: 'C:/xampp/php/php.ini',
    port: 8000,
    base: 'dist'
    // livereload: true
  });

  done();
}

// BrowserSync Reload
function browserSyncReload(done) {
  temp();
  browsersync.reload();
  done();
}

// Watch files
function watchFiles() {
  gulp.watch("./scss/**/*", css);
  gulp.watch("./src/**/*.html", browserSyncReload);
  gulp.watch("./src/**/*.php", browserSyncReload);
  gulp.watch("./img/*",syncImgs);
}
var template = require('gulp-html-header');

function temp() {
    gulp.src('./src/**/*.html')
        .pipe(template())
        .pipe(gulp.dest('dist'))
    gulp.src('./src/**/*.php')
        .pipe(template())
        .pipe(gulp.dest('dist'))
    gulp.src('./src/**/*.css')
        .pipe(template())
        .pipe(gulp.dest('dist'))
    gulp.src('./src/**/*.js')
        .pipe(template())
        .pipe(gulp.dest('dist'))
}
function syncImgs(){
  gulp.src('./img/*')
      .pipe(gulp.dest('./dist/img/'));
}

gulp.task("default", gulp.parallel('vendor', css));
// dev task
gulp.task("dev", gulp.parallel(watchFiles, browserSyncStart, temp, syncImgs));