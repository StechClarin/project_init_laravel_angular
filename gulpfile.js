const gulp = require('gulp');
const sass = require('gulp-dart-sass');
// const sass = require('gulp-sass');
const replace = require('gulp-replace');
const sync = require('browser-sync').create();
const sourcemaps = require('gulp-sourcemaps');
const concat = require('gulp-concat');
const rtlcss = require('gulp-rtlcss');
const cleanCSS = require('gulp-clean-css');
const rename = require('gulp-rename');
const terser = require('gulp-terser');
const imagemin = require('gulp-imagemin');
const gulpCopy = require('gulp-copy');

const options = require("./package.json").options;

const redefineconsole = '// redefine console';
const bynewconsole = redefineconsole + "\nconsole.log = function() {};";

gulp.task('prod', () => {
    return(
        gulp.src([options.assets.dist + '/js/BACKOFFICE.js'])
            .pipe(replace(options.links.dev, options.links.prod))
            .pipe(replace(redefineconsole, bynewconsole))
            .pipe(gulp.dest(options.assets.dist + '/js/'))
    );
});

gulp.task('test', () => {
    return(
        gulp.src([options.assets.dist + '/js/BACKOFFICE.js'])
            .pipe(replace(options.links.dev, options.links.test))
            .pipe(replace(redefineconsole, redefineconsole + "\nconsole.log = function() {};"))
            .pipe(gulp.dest(options.assets.dist + '/js/'))
    );
});

// Compile SCSS files and minify CSS files
gulp.task('sass', () => {

    return (
        gulp.src(options.assets.dev + '/sass/style.scss')
        .pipe(sass())
        .pipe(gulp.dest(options.assets.dist + '/css'))
        .pipe(cleanCSS())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(options.assets.dist + '/css/'))
        .pipe(sync.stream()));

});

gulp.task('updateBackOffice', () => {
    return (gulp.src([options.assets.dev + '/js/angular/*.*'])
        .pipe(gulp.dest(options.assets.dist + '/js')))
        .pipe(sync.stream());
});

gulp.task('compressDepsAngular', () => {
    return gulp.src([options.assets.dev + '/js/angular/modules/*.js'])
        .pipe(concat('angular-dependancies.js'))
        .pipe(gulp.dest(options.assets.dist + '/js'))
        .pipe(terser().on('error', function(e){
            console.log(e);
        }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(options.assets.dist + '/js'));
});

// Copy Fonts
gulp.task('plugins', () => {
    return gulp.src(options.assets.dev + '/plugins/**/*.*', { allowEmpty: true })
        .pipe(gulp.dest(options.assets.dist + '/plugins' , {prefix: 1}))
});

gulp.task('compress', () => {
    var ignoreFolderCompile = 'theme';

    var scanDirs = ['others'];
    var srcDirs = [];
    scanDirs.forEach((scanDir) => {
        srcDirs.push(options.assets.dev + '/js/' + scanDir + '/*.js', options.assets.dev + '/js/' + scanDir + '/**/*.js', options.assets.dev + '/js/' + scanDir + '/**/**/*.js', options.assets.dev + '/js/' + scanDir + '/**/**/**/*.js')
    });

    console.log('srcDir=> ', srcDirs);

    return (gulp.src([options.assets.dev + '/js/' + ignoreFolderCompile + '/*.js', options.assets.dev + 'js/' + ignoreFolderCompile + '/**/*.js',
        options.assets.dev + '/js/' + ignoreFolderCompile + '/**/**/*.js', options.assets.dev + '/js/' + ignoreFolderCompile + '/**/**/**/*.js'])
        .pipe(terser().on('error', function(e){
            console.log(e);
        }))
        //.pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(options.assets.dist + '/js/' + ignoreFolderCompile))
    && gulp.src(srcDirs)
        .pipe(concat('main.js'))
        .pipe(gulp.dest(options.assets.dist + '/js'))
        .pipe(terser().on('error', function(e){
            console.log(e);
        }))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(options.assets.dist + '/js')));
});


// Optimize images
gulp.task('images', () => {
    return gulp.src(options.assets.dev + '/media/**/*.*')
        //.pipe(imagemin({optimizationLevel: 7, progressive: true}))
        .pipe(gulp.dest(options.assets.dist + '/media'));
});

// Copy Fonts, ajax, audio, video, files .js se trouvant directement à la racine
gulp.task('others-assets', () => {
    return gulp.src([options.assets.dev + '/js/*.js', options.assets.dev + '/fonts/**/*.*', options.assets.dev + '/ajax/*.*', options.assets.dev + '/audio/*.*', options.assets.dev + '/json/*.*', options.assets.dev + '/video/*.*', options.assets.dev + '/js/typeahead/data/*.json'])
    .pipe(gulpCopy('public', {prefix: 1}));
});

gulp.task('serve', function() {
    sync.init({
        proxy: "http://localhost/" + options.links.dev,
        port: options.port + 1,
        files: ['resources/**/*.*','resources/**/**/*.*']
    });

    // Watch task
    gulp.watch([options.assets.dev + '/sass/*.scss', options.assets.dev + '/sass/**/*.scss', options.assets.dev + '/sass/**/**/*.scss', options.assets.dev + '/sass/**/**/**/*.scss'], gulp.series('sass'));

    gulp.watch(options.assets.dev + '/js/angular/modules/*.js', gulp.series('compressDepsAngular'));
    gulp.watch(options.assets.dev + '/js/angular/*.js', gulp.series('updateBackOffice'));

    gulp.watch([options.assets.dev + '/js/*.js', options.assets.dev + '/js/**/*.js', options.assets.dev + '/js/**/**/*.js'], gulp.series('compress','images'));

    // For Laravel
    gulp.watch(['*.php', 'resources/views/*.php', 'resources/views/**/*.php']).on('change', sync.reload);
});

gulp.task('default', gulp.parallel('images', 'others-assets', 'plugins', 'compress', 'sass', 'compressDepsAngular', 'updateBackOffice', 'serve'));

