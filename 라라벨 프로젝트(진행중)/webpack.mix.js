const mix = require('laravel-mix');
require('mix-tailwindcss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.styles([
    'resources/css/body.css',
    'resources/css/style.css',
    'resources/css/bootstrap.css'
], 'public/css/app.css').options({
    postCss: [
        require('postcss-css-variables')()
    ]
}).scripts([
    'resources/js/jquery-1.10.2.min.js',
    'resources/js/script.js',
    'resources/js/bootstrap.js'
], 'public/js/app.js').version();


// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         //
//     ]);

