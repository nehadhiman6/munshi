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

// mix.js('resources/js/app.js', 'public/js')
//     .vue()
//     .sass('resources/sass/app.scss', 'public/css');


    mix.js(['resources/js/app.js',
         "resources/js/core/Main.js",

    ], 'public/js')
    .vue({
        extractStyles: true,
        globalStyles: false
    })
    .js([
        "resources/js/customs/sidebar_toggle.js",
    ], 'public/js/custom.js')
    .js(["resources/js/core/LoginSession.js"],"public/js/session_out_login.js")
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/custom_style.scss', 'public/css')
   .styles(
    ["resources/css/style_structure.css",
    "resources/css/mCustomScrollbar.css",
    "resources/css/responsive.css",
    ],
    "public/assets/css/style_structure.css"
    )
    .styles(
        ["resources/css/project_style.css"],"public/assets/css/project_style.css"
    )
    .version();
