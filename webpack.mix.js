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

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
])
    .js("node_modules/swiper/swiper-bundle.js", "public/js")
    .postCss("node_modules/swiper/swiper-bundle.min.css", "public/css");


mix.copyDirectory('vendor/tinymce/tinymce', 'public/vendor/tinymce');
mix.copyDirectory('node_modules/sweetalert2', 'public/vendor/sweetalert2');
// mix.copyDirectory('node_modules/@fancyapps', 'public/vendor/@fancyapps');

if (mix.inProduction()) {
    mix.version();
}
