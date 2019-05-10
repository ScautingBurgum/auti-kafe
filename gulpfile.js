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
var gutil = require('gulp-util');




var localFiles = [
    './dist/**/*'
];

var remoteLocation = 'www/';

gulp.task('remote-deploy',function(){
    var config = require('./.env.json');
    css()
    temp()
    syncImgs()
    // gulp.parallel('vendor', css,temp,syncImgs)
    var sftp = require('gulp-sftp');

    return gulp.src('dist/**/*')
        .pipe(sftp({
            host: config.host,
            user: config.username,
            pass: config.password,
            remotePath: 'www/'
        }));
});


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

	//Markup

	gulp.src([
	    './node_modules/marked/marked.min.js'
	])
	.pipe(gulp.dest('./dist/vendor/marked'))

	//easyMDE
	gulp.src([
	    './node_modules/easymde/dist/*'
	])
	.pipe(gulp.dest('./dist/vendor/easymde'))

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
    bin: '/usr/bin/php',
    ini: '/etc/php/7.2/cli/php.ini',
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
    gulp.src(['./src/**/*.html','!./src/templates'])
        .pipe(template())
        .pipe(gulp.dest('dist'))
    gulp.src('./src/**/*.php')
        .pipe(template())
        .pipe(gulp.dest('dist'))
    gulp.src('./src/**/*.css')
        .pipe(template())
        .pipe(gulp.dest('dist'))
    return gulp.src('./src/**/*.js')
        .pipe(template())
        .pipe(gulp.dest('dist'))
}
function syncImgs(){
  return gulp.src('./img/*')
      .pipe(gulp.dest('./dist/img/'));
}

gulp.task("default", gulp.parallel('vendor', css,temp,syncImgs));
// dev task
gulp.task("temp",temp)
gulp.task("dev", gulp.parallel(watchFiles, browserSyncStart));
