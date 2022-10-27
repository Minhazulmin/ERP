const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/frontend_app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .options({ processCssUrls: false });

// BACKEND THEME CSS FILES MIX
mix.styles([
    'resources/js/assets/backend/css/AdminLTE.min.css',
    'resources/js/assets/backend/css/skins/_all-skins.min.css',
    'resources/js/assets/backend/css/style.css',
    'resources/js/assets/backend/css/datepicker.css',
    'resources/js/assets/backend/css/responsive.css',
    'resources/js/assets/backend/css/color.css',
    'resources/js/assets/backend/css/login.css'
], 'public/css/backend_layouts.css');

// BACKEND THEME JS FILES MIX
mix.scripts([
    'resources/js/assets/backend/js/jquery.slimscroll.min.js',
    'resources/js/assets/backend/js/fastclick.js',
    'resources/js/assets/backend/js/adminlte.min.js',
    'resources/js/assets/backend/js/demo.js'
], 'public/js/backend_layouts.js');


// FRONTEND THEME CSS FILES MIX
mix.styles([
    'resources/js/assets/web/css/bootstrap.min.css',
], 'public/css/frontend_layouts.css');

// FRONTEND THEME JS FILES MIX
mix.scripts([
    'resources/js/assets/web/js/bootstrap.bundle.min.js'
], 'public/js/frontend_layouts.js');


// COPY FILES / DIRECTORY
mix.copyDirectory('node_modules/font-awesome', 'public/packages/font-awesome')
    .copyDirectory('resources/js/assets/public', 'public')
    .copyDirectory('resources/js/assets/backend/images', 'public/images');

// FOR CHANK
let config = {
    output: {
        publicPath: (process.env.MIX_VUE_ROUTER_BASE) ? '/' + process.env.MIX_VUE_ROUTER_BASE + '/public/' : '/',
        chunkFilename: 'js/chunks/[name].js',
    },
};
mix.webpackConfig(config);
