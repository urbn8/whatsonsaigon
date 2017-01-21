const path = require('path')
const webpack = require('webpack')
const gulp = require('gulp')

const proxyMiddleware = require('http-proxy-middleware');
const webpackDevMiddleware = require('webpack-dev-middleware');
const webpackHotMiddleware = require('webpack-hot-middleware');

const config = require('./webpack.config')

const host = "http://localhost/whatsonsaigon"

const bundler = webpack(config)

const browserSync = require('browser-sync').create()

function filter(path, req) {
  return !path.match('^/browser-sync')
}

gulp.task('watch', function() {
  browserSync.init({
    port: 5000,
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
          target: host,
          changeOrigin: true,
          ws: true,
          logLevel: 'warn'
        }),
      ]
    }
  })
})

gulp.task('default', ['watch'])
