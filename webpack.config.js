const path = require('path')
const webpack = require('webpack')

const scriptsPath = path.resolve('./themes/default/assets/scripts')

module.exports = {
    entry: [
        'react-hot-loader/patch',
        'webpack-hot-middleware/client',
        scriptsPath + '/app.js'
    ],
    output: {
        path: path.join(__dirname, 'dist'),
        filename: 'bundle.js',
        publicPath: '/static/'
    },
    resolve: {
        extensions: ['.js', '.jsx', '.ts', '.tsx', '.css', '.scss'],
    },
    module: {
        rules: [
            {
                test: /\.jsx?$/,
                loader: 'babel-loader',
                include: scriptsPath,
                options: {
                    // Loader results would be cached for future use
                    cacheDirectory: true,
                    // Do not use .babelrc file
                    babelrc: false,
                    presets: [ 'es2015', 'react' ],
                    plugins: [ 'react-hot-loader/babel' ]
                },
            },
            {
                test: /\.tsx?$/,
                loader: 'awesome-typescript-loader',
                include: scriptsPath,
            },
        ]
    },
    plugins: [
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': '"development"',
            __DEV__: true
        }),

        // For HMR
        new webpack.HotModuleReplacementPlugin(),
        new webpack.NoEmitOnErrorsPlugin()
    ],
}