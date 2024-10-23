import { src, dest, watch, parallel } from 'gulp';

import gulpSass from 'gulp-sass';
import * as sassCompiler from 'sass'; // Importa el compilador de Sass
import cssnano from 'cssnano';
import postcss from 'gulp-postcss';
import autoPrefixer from 'autoprefixer';
import sourcemaps from 'gulp-sourcemaps';
import concat from 'gulp-concat';
import terser from 'gulp-terser-js';
import imagemin from 'gulp-imagemin';
import cache from 'gulp-cache';
import avif from 'gulp-avif';

// Configura el compilador de Sass
const sass = gulpSass(sassCompiler);

const path = {
    scss: 'src/scss/**/*.scss',
    css: 'build/css/app.css',
    js: 'src/js/**/*.js',
    img: 'src/img/**/*.{jpg,png}',
    imgmin: 'build/img/**/*.{jpg,png}',
};

// Compila el archivo SCSS a CSS
function compileSass() {
    return src(path.scss)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoPrefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('build/css'));
}

// Compila y minifica archivos JavaScript
function compileJS() {
    return src(path.js)
        .pipe(sourcemaps.init())
        .pipe(concat('bundle.js'))
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('build/js'));
}

// Optimiza las imágenes
function imageMin() {
    const settings = {
        optimizationLevel: 3
    };

    return src(path.img)
        .pipe(cache(imagemin(settings)))
        .pipe(dest('build/img'));
}

// Convierte imágenes a formato AVIF
function imgAvif() {
    const settings = {
        quality: 50
    };

    return src(path.img)
        .pipe(avif(settings))
        .pipe(dest('build/img'));
}

// Observa los cambios en los archivos y ejecuta tareas automáticamente
function autoCompile() {
    watch(path.scss, compileSass);
    watch(path.js, compileJS);
    watch(path.img, parallel(imgAvif, imageMin));
}

// Exporta las tareas para que Gulp las reconozca
export default parallel(compileSass, compileJS, autoCompile, imgAvif, imageMin);
