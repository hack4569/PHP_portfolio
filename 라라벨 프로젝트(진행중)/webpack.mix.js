const mix = require('laravel-mix');

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
    'resources/css/style.css'
], 'public/css/app.css').options({
    postCss: [
        require('postcss-css-variables')()
    ]
}).version();

mix.scripts([
    'resources/js/bootstrap.js',
    'resources/js/edu_common.js',
    'resources/js/script.js',
    'resources/js/jquery-1.10.2.min.js',
    'resources/js/jquery-ui.min.js',
    'resources/js/jquery.form.min.js'
], 'public/js/app.js').version();

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);

