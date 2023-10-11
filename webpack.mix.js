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

mix
	.js('resources/assets/js/pagination.js', 'public/js')
	.scripts(['resources/assets/js/art_pieces.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/art_pieces.js')
	.scripts(['resources/assets/js/artists.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/artists.js')
	.scripts(['resources/assets/js/categories.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/categories.js')
	.scripts(['resources/assets/js/changepass.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/changepass.js')
	.scripts(['resources/assets/js/main.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/main.js')
	.scripts(['resources/assets/js/media.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/media.js')
	.scripts(['resources/assets/js/menus.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/menus.js')
	.scripts(['resources/assets/js/promos.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/promos.js')
	.scripts(['resources/assets/js/subscribers.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/subscribers.js')
	.scripts(['resources/assets/js/users.js', 'resources/assets/js/alerts.js', 'resources/assets/js/global_functions.js'], 'public/js/users.js')

    .sass('resources/assets/css/colors.scss', 'public/css')
    .sass('resources/assets/css/login.scss', 'public/css')
    .sass('resources/assets/css/main.scss', 'public/css')
    .sass('resources/assets/css/web.scss', 'public/css');
