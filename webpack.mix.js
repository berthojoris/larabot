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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/chatfont.scss', 'public/css')
   .sass('resources/sass/chatfontawesome.scss', 'public/css')
   .sass('resources/sass/loader.scss', 'public/css')
   .sass('resources/sass/chat.scss', 'public/css');
