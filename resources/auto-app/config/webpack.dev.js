const helpers = require('./helpers');
const webpackMerge = require('webpack-merge');
const webpackMergeDll = webpackMerge.strategy({plugins: 'replace'});
const commonConfig = require('./webpack.common.js');

const DefinePlugin = require('webpack/lib/DefinePlugin');
const LoaderOptionsPlugin = require('webpack/lib/LoaderOptionsPlugin');
const DllBundlesPlugin = require('webpack-dll-bundles-plugin').DllBundlesPlugin;

const ENV = process.env.ENV = process.env.NODE_ENV = 'development';

module.exports = function(options) {

    return webpackMerge(commonConfig({env: ENV}), {

        devtool: 'cheap-module-source-map',

        output: {
            path: helpers.root('..', '..', 'public', 'js', 'build', 'auto-app'),
            publicPath: helpers.root('..', '..', 'public', 'js', 'build', 'auto-app'),
            filename: '[name].bundle.js',
            sourceMapFilename: '[file].map',
            chunkFilename: '[id].chunk.js',
            library: '[name]_lib',
            libraryTarget: 'var'
        },

        module: {

            rules: [
                {
                    test: /\.ts$/,
                    use: [
                        {
                            loader: 'tslint-loader',
                            options: {
                                configFile: 'tslint.json'
                            }
                        }
                    ]
                },

                {
                    test: /\.scss$/,
                    use: ['style-loader', 'css-loader', 'sass-loader'],
                    include: []
                },

            ]

        },

        plugins: [

            new LoaderOptionsPlugin({
                debug: true,
                options: {}
            }),

            new DefinePlugin({
                'ENV': JSON.stringify(ENV),
                'process.env': {
                    'ENV': JSON.stringify(ENV),
                    'NODE_ENV': JSON.stringify(ENV),
                }
            }),

            new DllBundlesPlugin({
                bundles: {
                    polyfills: [
                        'core-js',
                        {
                            name: 'zone.js',
                            path: 'zone.js/dist/zone.js'
                        },
                        {
                            name: 'zone.js',
                            path: 'zone.js/dist/long-stack-trace-zone.js'
                        },
                    ],
                    vendor: [
                        '@angular/platform-browser',
                        '@angular/platform-browser-dynamic',
                        '@angular/core',
                        '@angular/common',
                        '@angular/forms',
                        '@angular/http',
                        '@angular/router',
                        'rxjs',
                    ]
                },
                dllDir: helpers.root('..', '..', 'public', 'js', 'build', 'auto-app'),
                webpackConfig: webpackMergeDll(commonConfig({env: ENV}), {
                    devtool: 'cheap-module-source-map',
                    plugins: []
                })
            }),



        ],

        node: {
            global: true,
            crypto: 'empty',
            process: true,
            module: false,
            clearImmediate: false,
            setImmediate: false
        }

    });
}