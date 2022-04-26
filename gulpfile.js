// основной модуль и пути
import gulp from "gulp";
import rename from "gulp-rename";
import browserSync from "browser-sync";
import autoPrefixer from "gulp-autoprefixer";
import GulpCleanCss from "gulp-clean-css";

import gulpSass from "gulp-sass";
import dartSass from "sass";
const sass = gulpSass(dartSass);

browserSync.create();


// запуск сервера
gulp.task('server', function() {
    browserSync.init({
        server: {
            baseDir: './',
        },
    })
});

//преобразование предпроцессора в стили 
gulp.task('styles', function(){
    return gulp.src('./sass/**/*.+(scss|sass)')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(rename({
            prefix: "",
            suffix: ".min"
        }))
        .pipe(autoPrefixer({}))
        .pipe(GulpCleanCss({compatibility: 'ie8'}))
        .pipe(gulp.dest('./css'))
        .pipe(browserSync.stream());
});

//слежка за работой приложения
gulp.task('watch', function() {
    gulp.watch("./sass/**/*.+(scss|sass)", gulp.parallel('styles'));
    gulp.watch("./*.html").on("change", browserSync.reload);
});


gulp.task('default', gulp.parallel('server', 'watch', 'styles'));
