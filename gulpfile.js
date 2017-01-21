const path = require('path')
const webpack = require('webpack')
const gulp = require('gulp')

const proxyMiddleware = require('http-proxy-middleware');
const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');

const config = require('./webpack.config')

const APP_HOST = "http://localhost/whatsonsaigon"
const HOST_SERVER_ADDRESS = 'localhost'
const HOST_SERVER_PORT = 5000

const bundler = webpack(config)

const browserSync = require('browser-sync').create()

function filter(path, req) {
  return !path.match('^/browser-sync')
}

gulp.task('watch', function() {
  browserSync.init({
    port: HOST_SERVER_PORT,
    logPrefix		: "Laravel BrowserSync",
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
          target: APP_HOST,
          changeOrigin: true,
          ws: true,
          logLevel: 'warn'
        }),
      ]
    }
  })
})

gulp.task('default', ['watch'])
