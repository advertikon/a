'use strict';

var proxyurl    = 'http://arbole.dev/';

var gulp        = require( 'gulp' ),
    watch       = require( 'gulp-watch' ),
    prefixer    = require( 'gulp-autoprefixer' ),
    sourcemap   = require( 'gulp-sourcemaps' ),
    uglify      = require( 'gulp-uglify' ),
    sass        = require( 'gulp-sass' ),
    rigger      = require( 'gulp-rigger' ),
    cssmin      = require( 'gulp-clean-css' ),
    imagemin    = require( 'gulp-imagemin' ),
    pngquant    = require( 'imagemin-pngquant' ),
    rimraf      = require( 'rimraf' ),
    browserSync = require( 'browser-sync' ),
    spritesmith = require( 'gulp.spritesmith' ),
    merge       = require( 'merge-stream' ),
    plumber     = require( 'gulp-plumber' ),
    rename      = require( 'gulp-rename' ),
    sourcemaps  = require( 'gulp-sourcemaps' ),
    reload      = browserSync.reload;

var path = {
  build: {
    js:     './assets/build/js/',
    css:    './assets/build/css/',
    img:    './assets/build/img/',
    fonts:  './assets/build/fonts/',
    svg:    './assets/build/svg/'
  },
  src: {
    js:     './assets/sources/js/*.js',
    scss:   './assets/sources/scss/*.scss',
    img:    './assets/sources/img/**/*.*',
    fonts:  './assets/sources/fonts/**/*.*',
    svg:    './assets/sources/svg/**/*.svg'
  },
  watch: {
    js:     './assets/sources/js/*.js',
    img:    './assets/sources/img/**/*.*',
    scss:   './assets/sources/scss/*.scss',
    fonts:  './assets/sources/**/*.*',
    svg:    './assets/sources/**/*.svg'
  },
  clean:    './assets/build'
};
var config = {
  logPrefix:  "EGO Devil",
  proxy:      proxyurl,
  port:       9000
};

gulp.task('js:build', function(){
  gulp.src(path.src.js)
      .pipe(plumber())
      .pipe(rigger())
      .pipe(uglify())
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest(path.build.js))
      .pipe(reload({ stream: true }));
});
gulp.task('scss:build', function(){
  gulp.src(path.src.scss)
      .pipe(plumber())
      .pipe(sourcemap.init())
      .pipe(sourcemaps.init())
      .pipe(sass())
      .pipe(prefixer())
      .pipe(cssmin())
      .pipe(rename({suffix: '.min'}))
      .pipe(sourcemap.write( path.build.css ))
      .pipe(gulp.dest( path.build.css ))
      .pipe(sourcemaps.write( path.build.css ))
      .pipe(reload({ stream: true }));
});
gulp.task('image:build', function(){
  return gulp.src(path.src.img)
      .pipe(plumber())
      .pipe(imagemin({
        progressive: true,
        svgoPlugins: [{
          removeViewBox: false
        }],
        use: [pngquant()],
        interlaced: true
      }))
      .pipe(gulp.dest(path.build.img))
      .pipe(reload({ stream: true }));
});
gulp.task('fonts:build', function(){
  gulp.src(path.src.fonts)
      .pipe(plumber())
      .pipe(gulp.dest(path.build.fonts))
});
gulp.task('svg:build', function(){
  gulp.src(path.src.svg)
      .pipe(plumber())
      .pipe(gulp.dest(path.build.svg))
});
gulp.task('build', [
  'js:build',
  'scss:build',
  'image:build',
  'fonts:build',
  'svg:build'
]);
gulp.task('watch', function(){
  watch([path.watch.scss], function(event, cb){
    gulp.start('scss:build');
  });
  watch([path.watch.js], function(event, cb){
    gulp.start('js:build');
  });
  watch([path.watch.img], function(event, cb){
    gulp.start('image:build');
  });
  watch([path.watch.fonts], function(event, cb){
    gulp.start('fonts:build');
  });
  watch([path.watch.svg], function(event, cb){
    gulp.start('svg:build');
  });
  watch('./**/*.html').on('change', browserSync.reload);
  watch('./**/*.php').on('change', browserSync.reload);
});
gulp.task('webserver', function(){
  browserSync(config);
});
gulp.task('clean', function(cd){
  rimraf(path.clean, cd);
});
gulp.task('default', ['build', 'webserver', 'watch']);