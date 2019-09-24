const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.copyDirectory('resources/images', 'public/images')
    .copy('resources/images/favicon.ico', 'public/favicon.ico')
    .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.min.js')
    .copy('node_modules/popper.js/dist/umd/popper.min.js', 'public/js/popper.min.js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
