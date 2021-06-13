let mix = require('laravel-mix');
require('dotenv').config();

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
mix.setResourceRoot(process.env.APP_URL);
mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
mix.copyDirectory('node_modules/font-awesome/fonts', 'public/fonts/font-awesome');
mix.webpackConfig({
    resolve: {
        extensions: ['.vue', '.js'],
        alias: {
            '@component': __dirname + '/resources/assets/js/components',
            '@libs': __dirname + '/resources/assets/js/libs',
            '@node': __dirname + '/node_modules/assets/js/libs',
        }
    }
});