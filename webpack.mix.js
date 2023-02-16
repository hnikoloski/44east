const mix = require("laravel-mix");
const CompressionWebpackPlugin = require("compression-webpack-plugin");

mix
    .options({
        processCssUrls: false,
    })
    .js('src/app.js', 'js')
    .sass('src/app.scss', 'css')
    .sass('src/editor.scss', 'css')
    .setPublicPath('dist')
    .sourceMaps(true, 'source-map')
    .copyDirectory('src/sass/fonts/nunito', 'dist/fonts/nunito')
    // copy /node_modules/material-symbols/material-symbols-sharp.woff2 to /dist/css/material-symbols-sharp.woff2
    .copy('node_modules/material-symbols/material-symbols-sharp.woff2', 'dist/css/material-symbols-sharp.woff2')
    .copy('node_modules/material-symbols/material-symbols-sharp.woff2', 'dist/css/material-symbols-outlined.woff2')
    .copy('node_modules/material-symbols/material-symbols-sharp.woff2', 'dist/css/material-symbols-rounded.woff2')

    .disableNotifications();

mix.webpackConfig({
    plugins: [
        new CompressionWebpackPlugin({
            algorithm: "gzip",
            test: /\.js$|\.css$|\.html$|\.svg$/,
            threshold: 10240,
            minRatio: 0.8
        })
    ]
});