const path = require('path')
const elixir = require('laravel-elixir')
require('laravel-elixir-webpack-official')

const assetsPath = path.resolve('./themes/default/assets')

Elixir.webpack.mergeConfig({
    resolve: {
        extensions: ['', '.js', '.jsx', '.ts', '.tsx', '.css', '.scss'],
    },
    module: {
        loaders: [
            {
                test: /\.tsx?$/,
                loader: 'awesome-typescript-loader',
                include: assetsPath,
            },
        ]
    }
});

elixir(function(mix) {
    mix.webpack('app.js', 'themes/default/assets/dist', 'themes/default/assets/scripts');
});
