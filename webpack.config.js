const path = require('path');
module.exports = {
    // define entry file and output
    entry: {
        main: './src/index.js',
    },
    output: {
        path: path.resolve('./web/res'),
        filename: '[name].js'
    },
    // define babel loader
    module: {
        rules: [{
            loader: 'babel-loader',
            test: /\.js$/,
            exclude: /node_modules/
          }, {
            test: /\.s?css$/,
            use: [
              'style-loader',
              'css-loader',
              'sass-loader'
            ]
          }, {
            test: /\.(png|jpe?g|gif|svg)$/i,
            use: [
              {
                loader: 'file-loader',
              }
            ]
          }]
    }
};