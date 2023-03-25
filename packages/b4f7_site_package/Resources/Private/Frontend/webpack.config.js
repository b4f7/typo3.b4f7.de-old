const webpack = require('webpack');
const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');

const isDev = process.env.NODE_ENV !== 'production';

module.exports = {
  mode: process.env.NODE_ENV,
  devtool: isDev ? 'source-map' : 'cheap-source-map',
  entry: {
    index: path.resolve(__dirname, './JavaScript/index.js'),
  },
  module: {
    rules: [
      {
        test: /\.s?[ac]ss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: 'css-loader',
            options: {
              sourceMap: isDev,
            },
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: isDev,
            },
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: isDev,
            },
          },
        ],
      },
      {
        test: /\.js$/,
        use: [
          {
            loader: 'babel-loader',
            options: {
              extends: path.resolve(__dirname, '.babelrc'),
            },
          },
        ],
      },
      {
        test: /\.(ttf|eot|svg|woff(2)?)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
        type: 'asset/resource',
        generator: {
          filename: 'Fonts/[name][ext]',
        },
      },
      {
        test: /\.(jpe?g|png|gif)$/,
        type: 'asset/resource',
        generator: {
          filename: 'Images/[name][ext]',
        },
      },
    ],
  },
  output: {
    path: path.resolve(__dirname, '../../Public/'),
    filename: 'JavaScript/[name].js',
    chunkFilename: 'JavaScript/[name].[contenthash].js',
  },
  optimization: {
    minimize: !isDev,
    minimizer: [
      new TerserJSPlugin(),
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'Css/[name].css',
    }),
  ],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'TypeScript/'),
      '~': path.resolve(__dirname, 'TypeScript/'),
    }, extensions: ['.js', '.jsx', '.ts', '.tsx', '.json', '.vue'],
  },
};
