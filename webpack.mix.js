// webpack.mix.js

const mix = require("laravel-mix");

mix
    .options({
        processCssUrls: false,
    })
    .js('src/app.js', 'js')
    .sass('src/app.scss', 'css')
    .sass('src/editor.scss', 'css')
    .setPublicPath('dist')
    .sourceMaps(true, 'source-map')
    .disableNotifications();

