const path = require('path');
const { FlarumWebpackPlugin } = require('flarum-webpack');

module.exports = {
  name: 'acolasi-autolock',
  entry: {
    admin: './src/admin.ts',
  },
  output: {
    path: path.resolve(__dirname, '../js/dist'),
    publicPath: '/assets/extensions/acolasi-autolock/',
  },
  resolve: {
    extensions: ['.ts', '.tsx', '.js'],
    alias: {
      'flarum': path.resolve(__dirname, '../../../vendor/flarum/core/js/dist'),
    },
  },
  module: {
    rules: [
      {
        test: /\.ts(x?)$/,
        exclude: /node_modules/,
        use: ['ts-loader'],
      },
    ],
  },
  plugins: [
    new FlarumWebpackPlugin(),
  ],
};
