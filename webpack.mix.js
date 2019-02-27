const mix = require('laravel-mix');

const webpackConfig = { "plugins" : []};

if (mix.inProduction()) {
    mix.disableNotifications();

    mix.sourceMaps();
}

mix.webpackConfig(webpackConfig);

mix.js('resources/js/page_keys.js', 'public/js/page_keys.js');
mix.js('resources/js/vendor.js', 'public/js/vendor.js');
mix.js('resources/js/app.js', 'public/js/app.js');
mix.sass('resources/sass/vendor.scss', 'public/css/vendor.css');
mix.sass('resources/sass/app.scss', 'public/css/app.css');


mix.version();