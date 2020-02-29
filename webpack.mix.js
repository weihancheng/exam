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
   .version();

mix.copyDirectory('resources/assets', 'public/assets');

// 减少cpu占用
if(Mix.isWatching()){
    mix.webpackConfig({
        watchOptions:{
            ignored : /node_modules/,
            //poll : 1000
        },
    })
}
