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

mix.copy('resources/images', 'public/images');

mix.js('resources/js/app.js', 'public/js/app.js');
mix.js('resources/js/homepage/app.js', 'public/js/homepage/app.js');
mix.js('resources/js/blog/app.js', 'public/js/blog/app.js');
mix.js('resources/js/single-blog/app.js', 'public/js/single-blog/app.js');
mix.js('resources/js/single-portfolio/app.js', 'public/js/single-portfolio/app.js');
mix.js('resources/js/landing.js', 'public/js/landing.js');
// Add more mix.js() calls for each JS file
mix.sass('resources/sass/ltr.scss', 'public/css')
mix.sass('resources/sass/landing.scss', 'public/css')
mix.sass('resources/sass/custom.scss', 'public/css/style.css', {}, [
    require("rtlcss")({}),
]).sourceMaps().options({
    processCssUrls: true}); // Add this line to enable source maps;

mix.webpackConfig({
    stats: {
        children: true,
    },
});