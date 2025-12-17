const path = require("path");
const webpack = require("webpack");
const Dotenv = require("dotenv-webpack");
const CompressionPlugin = require("compression-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
module.exports = {
    entry: {
        dtable: "./assets/script/dtable.js",
    },
    // เลือก output folder
    output: {
        filename: "js/[name].js",
        path: path.resolve(__dirname, "assets/dist"),
    },
    mode: process.env.STATE,
    optimization: {
        concatenateModules: true,
        minimize: true,
        minimizer: [
            new TerserPlugin({
                parallel: true, // ✅ เปิด multi-core minify
                terserOptions: {
                    format: {
                        comments: false, // ลบคอมเมนต์ทิ้ง
                    },
                },
                extractComments: false, // ไม่แยก LICENSE ออกมาเป็นไฟล์ .txt
            }),
        ],
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"],
            },
            {
                test: /\.md$/,
                use: "raw-loader",
            },
        ],
    },
    plugins: [
        new Dotenv({
            path: path.resolve(__dirname, "./.env"),
        }),
        new CompressionPlugin({
            algorithm: "gzip", // หรือใช้ "brotliCompress" ก็ได้
            test: /\.(js|css|html|svg)$/,
            threshold: 10240,
            minRatio: 0.8,
            exclude: /public/, // <<< อย่ามาบีบอัดไฟล์ที่ copy มา
        }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery",
        }),
        // copy font and image from webasset
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: path.resolve( __dirname,"node_modules/@amec/webasset/src/fonts"),
                    to: path.resolve(__dirname, "assets/fonts"),
                    noErrorOnMissing: true,
                },
                {
                    from: path.resolve( __dirname,"node_modules/@amec/webasset/src/images"),
                    to: path.resolve(__dirname, "assets/images"),
                    noErrorOnMissing: true,
                }
            ]
        })
    ],
    cache:
        process.env.STATE === "production"
            ? false
            : {
                  type: "filesystem",
                  //   cacheDirectory: path.resolve(__dirname, '.cache/webpack'),
                  buildDependencies: {
                      config: [__filename],
                  },
              },
};
