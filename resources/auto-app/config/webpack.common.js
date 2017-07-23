const webpack = require('webpack');
const NormalModuleReplacementPlugin = require('webpack/lib/NormalModuleReplacementPlugin');
const ContextReplacementPlugin = require('webpack/lib/ContextReplacementPlugin');
const CommonsChunkPlugin = require('webpack/lib/optimize/CommonsChunkPlugin');
const CheckerPlugin = require('awesome-typescript-loader').CheckerPlugin;
const LoaderOptionsPlugin = require('webpack/lib/LoaderOptionsPlugin');
const ngcWebpack = require('ngc-webpack');
const helpers = require('./helpers');

const AOT = helpers.hasNpmFlag('aot');

module.exports = function(options) {

    isProd = options.env === 'production';

    return {

        //cache: false,

        entry: Object.assign({
            polyfills: './src/polyfills.browser.ts'
        }, {
            auto_app: AOT ? './src/main.aot.ts' : './src/main.ts'
        }),

        resolve: {
            extensions: ['.ts', '.js', '.json'],
            modules: [
                helpers.root('node_modules')
            ]
        },

        module: {

            rules: [

                {
                    test: /\.ts$/,
                    use: [
                        {
                            loader: 'ng-router-loader',
                            options: {
                                loader: 'async-import',
                                genDir: 'compiled',
                                aot: AOT
                            }
                        },
                        {
                            loader: 'awesome-typescript-loader'
                        },
                        {
                            loader: 'angular2-template-loader'
                        }
                    ]
                },

                {
                    test: /\.json$/,
                    use: 'json-loader'
                },

                {
                    test: /\.css$/,
                    use: ['to-string-loader', 'css-loader']
                },

                {
                    test: /\.scss$/,
                    use: ['to-string-loader', 'css-loader', 'sass-loader']
                },

                {
                    test: /\.html$/,
                    use: 'raw-loader'
                },

                {
                    test: /\.(jpg|png|gif)$/,
                    use: 'file-loader'
                },

                {
                    test: /\.(eot|woff2?|svg|ttf)([\?]?.*)$/,
                    use: 'file-loader'
                }
            ],

        },

        plugins: [
            new LoaderOptionsPlugin({}),

            new CheckerPlugin(),

            new CommonsChunkPlugin({
                name: 'polyfills',
                chunks: ['polyfills']
            }),

            new CommonsChunkPlugin({
                name: 'vendor',
                chunks: ['auto_app'],
                minChunks: function(module) {
                    return /node_modules/.test(module.resource)
                }
            }),

            new CommonsChunkPlugin({
                name: ['polyfills', 'vendor'].reverse()
            }),

            new LoaderOptionsPlugin({}),

            new ContextReplacementPlugin(
                /angular(\\|\/)core(\\|\/)@angular/,
                helpers.root('src'), // location of your src
                {
                    // your Angular Async Route paths relative to this root directory
                }
            ),

            new ngcWebpack.NgcWebpackPlugin({
                disabled: !AOT,
                tsConfig: helpers.root('tsconfig.json')
            })

        ],

        node: {
            global: true,
            crypto: 'empty',
            process: true,
            module: false,
            clearImmediate: false,
            setImmediate: false
        }

    };
}