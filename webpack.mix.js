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
    .js('resources/js/createCompte.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/index.scss', 'public/css')
    .sass('resources/sass/moncompte.scss', 'public/css')
    .sass('resources/sass/bancaire.scss', 'public/css')
    .sass('resources/sass/showcompte.scss', 'public/css')
    .sass('resources/sass/show-clients.scss', 'public/css')
    .sass('resources/sass/create-client.scss','public/css');
