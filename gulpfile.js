const path = require('path')
const webpack = require('webpack')
const elixir = require('laravel-elixir')

const proxyMiddleware = require('http-proxy-middleware');
const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');

// require('laravel-elixir-webpack-official')
const BrowserSync = require('laravel-elixir-browsersync')

const assetsPath = path.resolve('./themes/default/assets/scripts')

// Elixir.webpack.mergeConfig({
//     babel: {
//         // Loader results would be cached for future use
//         cacheDirectory: true,
//         // Do not use .babelrc file
//         babelrc: false,
//         presets: [ 'es2015', 'react' ],
//         plugins: [ 'react-hot-loader/babel' ]
//     },
//     entry: [
//         'webpack-dev-server/client?http://localhost:3000',
//         'webpack/hot/only-dev-server',
//         'react-hot-loader/patch',
//         assetsPath + '/app.js'
//     ],
//     output: {
//         path: path.join(__dirname, 'dist'),
//         filename: 'bundle.js',
//         publicPath: '/static/'
//     },
//     resolve: {
//         extensions: ['', '.js', '.jsx', '.ts', '.tsx', '.css', '.scss'],
//     },
//     module: {
//         loaders: [
//             {
//                 test: /\.jsx?$/,
//                 loader: 'babel',
//                 include: assetsPath,
//             },
//             {
//                 test: /\.tsx?$/,
//                 loader: 'awesome-typescript-loader',
//                 include: assetsPath,
//             },
//         ]
//     },
//     plugins: [
//         new webpack.DefinePlugin({
//             'process.env.NODE_ENV': '"development"',
//             __DEV__: true
//         }),

//         new webpack.optimize.OccurrenceOrderPlugin(true),

//         // For HMR
//         new webpack.HotModuleReplacementPlugin(),
//         new webpack.NoErrorsPlugin()
//     ],
// });

// console.log(JSON.stringify(Elixir.webpack))

const config = require('./webpack.config')
const host = "http://localhost/whatsonsaigon"

const bundler = webpack(config)

console.log(JSON.stringify(bundler))

var browserSync = require('browser-sync').create()

function filter(path, req) {
  return !path.match('^/browser-sync')
}

elixir(function(mix) {
    // mix.webpack('app.js', 'themes/default/assets/dist', 'themes/default/assets/scripts');
    // BrowserSync.init();
    browserSync.init({
        // proxy 			: "http://localhost/whatsonsaigon",
        port: 5000,
        logPrefix		: "Laravel Eixir BrowserSync",
        logConnections	: false,
        reloadOnRestart : false,
        open: false,
        notify: false,
        server: {
            baseDir: './',
            middleware: [
                webpackDevMiddleware(bundler, {
                    publicPath: '/static/',
                    historyApiFallback: true,
                    noInfo: true,
                    stats: {
                        colors: true,
                        version: false,
                        hash: false,
                        timings: false,
                        chunks: false,
                        chunkModules: false
                    }
                }),
                webpackHotMiddleware(bundler),
                proxyMiddleware(filter, {
                    target: host,
                    changeOrigin: true,
                    ws: true,
                    logLevel: 'warn'
                }),
            ]
        }
    })
});
