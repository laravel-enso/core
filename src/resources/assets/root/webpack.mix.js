let mix = require('laravel-mix').mix;

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */

mix
	// .copy('resources/assets/images', 'public/images')
	// .copy('node_modules/bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/bootstrap')
	// .copy('resources/assets/libs/datatables-lang', 'public/libs/datatables-lang')
	// .copy('resources/assets/libs/datatables-editor/js', 'public/libs/datatables-editor')

	// .combine([
	// 	"resources/assets/libs/datatables-editor/css/editor.dataTables.min.css",
	// 	"resources/assets/libs/checkbox-css/mk-toggle-radio-check.css",
	// 	"node_modules/admin-lte/dist/css/adminlte.css",
	// 	"node_modules/admin-lte/dist/css/skins/_all-skins.css",
	// ], 'public/css/all.css')

	.js('resources/assets/js/app.js', 'public/js');
	// .js('resources/assets/js/auth.js', 'public/js')
	// .js('resources/assets/js/defaults.js', 'public/js')
	// .js('resources/assets/js/vendor/laravel-enso/pages/generic.js', './public/js/vendor/laravel-enso/pages/')
	// .js('resources/assets/js/vendor/laravel-enso/pages/users/index.js', './public/js/users/')
	// .js('resources/assets/js/vendor/laravel-enso/pages/users/show.js', './public/js/users/')
	// .js('resources/assets/js/vendor/laravel-enso/pages/localisation/index.js', './public/js/vendor/laravel-enso/pages/localisation/')
	// .js('resources/assets/js/vendor/laravel-enso/pages/menus/index.js', './public/js/vendor/laravel-enso/pages/menus/')
	// .js('resources/assets/js/vendor/laravel-enso/pages/roles/edit.js', './public/js/vendor/laravel-enso/pages/roles/')
	// .js('resources/assets/js/vendor/laravel-enso/pages/index.js', './public/js/vendor/laravel-enso/pages/')

	// .sass('resources/assets/sass/app.scss', 'public/css')
	// .sass('resources/assets/sass/main.scss', 'public/css')
	// .sass('resources/assets/sass/auth.scss', 'public/css')
	// .sass('resources/assets/sass/error.scss', 'public/css')
	// .sass('resources/assets/sass/welcome.scss', 'public/css')
	// .version();