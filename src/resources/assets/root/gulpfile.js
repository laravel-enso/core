const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

elixir(mix => {
	mix.copy('resources/assets/libs/datatables-editor/js', 'public/libs/datatables-editor') //private lib
		.copy('resources/assets/images', 'public/images')
		.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/', 'public/fonts/bootstrap')
		.copy('resources/assets/libs/datatables-lang', 'public/libs/datatables-lang');

    mix.styles([
		"resources/assets/libs/datatables-editor/css/editor.dataTables.min.css",
		"resources/assets/libs/checkbox-css/mk-toggle-radio-check.css",
		"node_modules/admin-lte/dist/css/adminlte.css",
		"node_modules/admin-lte/dist/css/skins/_all-skins.css",
	], 'public/css/all.css', './');

	mix.sass('app.scss')
		.sass('main.scss')
		.sass('auth.scss')
		.sass('error.scss')
		.sass('welcome.scss')
		.webpack('auth.js')
		.webpack('app.js')
		.webpack('defaults.js')
		.webpack('vendor/laravel-enso/pages/generic.js', './public/js/vendor/laravel-enso/pages/')
		.webpack('vendor/laravel-enso/pages/users/index.js', './public/js/users/')
		.webpack('vendor/laravel-enso/pages/users/show.js', './public/js/users/')
		.webpack('vendor/laravel-enso/pages/localisation/index.js', './public/js/vendor/laravel-enso/pages/localisation/')
		.webpack('vendor/laravel-enso/pages/menus/index.js', './public/js/vendor/laravel-enso/pages/menus/')
		.webpack('vendor/laravel-enso/pages/roles/edit.js', './public/js/vendor/laravel-enso/pages/roles/')
		.webpack('vendor/laravel-enso/pages/index.js', './public/js/vendor/laravel-enso/pages/');

	mix.version([
		'css/all.css', 'css/app.css', 'css/main.css', 'css/auth.css',
		'css/error.css', 'css/welcome.css', 'js/auth.js', 'js/app.js', 'js/defaults.js'
	]);
});