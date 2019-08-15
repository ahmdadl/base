const path = require('path');

module.exports = {
    mode: "development",
    entry: "./resources/typescript/app.ts",
    devtool: 'inline-source-map',
    output: {
        path: path.resolve(__dirname, './public/assets/js'),
        filename: "app.js"
    },
    resolve: {
        extensions: [".ts"]
    },
    module: {
        rules: [
            // all files with a '.ts' extension will be handled by 'ts-loader'
            { test: /\.ts$/, use: ["ts-loader"], exclude: /node_modules/ }
        ]
    }
}