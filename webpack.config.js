const path = require('path')
const webpack = require('webpack')

const assetsPath = path.resolve('./themes/default/assets/scripts')

module.exports = {
    babel: {
        // Loader results would be cached for future use
        cacheDirectory: true,
        // Do not use .babelrc file
        babelrc: false,
        presets: [ 'es2015', 'react' ],
        plugins: [ 'react-hot-loader/babel' ]
    },
    entry: [
        // 'webpack-dev-server/client?http://localhost:3000',
        // 'webpack/hot/only-dev-server',
        'react-hot-loader/patch',
        'webpack-hot-middleware/client',
        assetsPath + '/app.js'
    ],
    output: {
        path: path.join(__dirname, 'dist'),
        filename: 'bundle.js',
        publicPath: '/static/'
    },
    resolve: {
        extensions: ['', '.js', '.jsx', '.ts', '.tsx', '.css', '.scss'],
    },
    module: {
        loaders: [
            {
                test: /\.jsx?$/,
                loader: 'babel',
                include: assetsPath,
            },
            {
                test: /\.tsx?$/,
                loader: 'awesome-typescript-loader',
                include: assetsPath,
            },
        ]
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': '"development"',
            __DEV__: true
        }),

        new webpack.optimize.OccurrenceOrderPlugin(true),

        // For HMR
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoErrorsPlugin()
    ],
}