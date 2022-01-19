/**
 * Webpack Build Configurations
 *
 * @member {webpack} webpack
 */
const webpack = require( 'webpack' );
const path = require( 'path' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const CssMinimizerPlugin = require( 'css-minimizer-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );

// Check for production mode.
const isProduction = process.env.NODE_ENV === 'production';

const loaders = {
    cssLoader: {
        loader: 'css-loader',
        options: {
            sourceMap: true,
        },
    },
    postCss: {
        loader: 'postcss-loader',
        options: {
            sourceMap: true,
        },
    },
    sassLoader: {
        loader: 'sass-loader',
        options: {
            sourceMap: true,
        },
    },
};

/**
 * @typedef webpack.Configuration
 * @member {webpack.Configuration} config
 */
const config = {
    mode: isProduction ? 'production' : 'development',
    devtool: isProduction ? false : 'inline-source-map',
    resolve: {
        alias: {
            scripts: path.resolve( __dirname, 'assets', 'scripts' ),
            styles: path.resolve( __dirname, 'assets', 'styles' ),
        },
    },
    entry: {
        public: 'scripts/public.js',
        admin: 'scripts/admin.js',
    },
    output: {
        path: path.resolve( __dirname, 'assets', 'dist' ),
        filename: '[name].js',
        clean: true,
    },
    externals: {
        // Set jQuery to be an external resource.
        'jquery': 'jQuery',
    },
    plugins: [
        // Extract all css into one file.
        new MiniCssExtractPlugin(),

        // Provide jQuery instance for all modules.
        new webpack.ProvidePlugin( {
            '$': 'jquery',
            'jQuery': 'jquery',
        } ),
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                include: path.resolve( __dirname, 'assets', 'scripts' ),
                use: {
                    loader: 'babel-loader',
                    options: {
                        // Do not use the .babelrc configuration file.
                        babelrc: false,
                        // The loader will cache the results of the loader in node_modules/.cache/babel-loader.
                        cacheDirectory: true,

                        // Enable latest JavaScript features.
                        presets: [ '@babel/preset-env' ],

                        // Enable dynamic imports.
                        plugins: [ '@babel/plugin-syntax-dynamic-import' ],
                    },
                },
            },
            {
                test: /\.css$/,
                use: [ MiniCssExtractPlugin.loader, loaders.cssLoader, loaders.postCss ],
            },
            {
                test: /\.scss$/,
                use: [ MiniCssExtractPlugin.loader, loaders.cssLoader, loaders.sassLoader ],
            },
            {
                test: /\.(woff(2)?|eot|ttf|otf)(\?[a-z0-9=\.]+)?$/,
                use: {
                    loader: 'url-loader?name=../fonts/[name].[ext]',
                },
            },
            {
                test: /\.(svg|gif|png|jpeg|jpg)(\?[a-z0-9=\.]+)?$/,
                use: {
                    loader: 'url-loader?name=../images/[name].[ext]',
                },
            },
        ],
    },
    watchOptions: {
        poll: 500,
    },
    optimization: {
        runtimeChunk: false,
        mangleExports: 'size',
        minimize: isProduction,
        minimizer: [
            new CssMinimizerPlugin( { parallel: true } ),
            new TerserPlugin( {
                extractComments: {
                    condition: /^\**!|@preserve|@license|@cc_on/i,
                    filename: 'licenses.txt',
                    banner: ( licenseFile ) => {
                        return `License information can be found in ${ licenseFile }`;
                    },
                },
                terserOptions: {
                    sourceMap: true,
                    mangle: true, // Note `mangle.properties` is `false` by default.
                    module: false,
                    output: {
                        comments: false,
                    },
                },
            } ),
        ],
    },
    stats: {
        assets: false,
        modules: false,
        builtAt: false,
        timings: false,
        version: false,
    },
};

module.exports = config;
