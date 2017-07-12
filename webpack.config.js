// webpack.config.js
var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .addEntry('app', './app/Resources/public/js/packy.js')
    .addEntry('highcharts', [
        'highcharts',
        'highcharts/css/highcharts.css',
    ])
    .createSharedEntry('vendor', [
        'jquery',
        'tether',
        'bootstrap-sass',
        'admin-lte',
        'highcharts',
        'bootstrap-sass/assets/stylesheets/_bootstrap.scss',
        'font-awesome/css/font-awesome.css',
        'admin-lte/dist/css/AdminLTE.css',
        'admin-lte/dist/css/skins/skin-purple.css'
    ])
    .enableSassLoader({
        resolve_url_loader: false
    })
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
