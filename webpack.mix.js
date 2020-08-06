const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const webpack = require('webpack');

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

mix.options({
    terser: {
        terserOptions: {
            compress: {
                drop_console: true,
            },
        },
    },
})
    .postCss('resources/css/vapor-ui.css', 'public/app.css')
    .options({
        postCss: [tailwindcss('./tailwind.config.js')],
    })
    .setPublicPath('public')
    .js('resources/js/app.js', 'public')
    .version()
    .webpackConfig({
        resolve: {
            symlinks: false,
            alias: {
                '@': path.resolve(__dirname, 'resources/js/'),
            },
        },
        plugins: [new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)],
    })
    .copy('public', '../vapor-uitest/public/vendor/vapor-ui')
    .copy('public', './vendor/orchestra/testbench-core/laravel/public/vendor/vapor-ui');
