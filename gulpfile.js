const elixir = require('laravel-elixir')
require('laravel-elixir-webpack-official')

elixir(function(mix) {
    mix.webpack('app.js', 'themes/default/assets/dist', 'themes/default/assets/scripts');
});
