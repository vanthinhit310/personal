let mix = require("laravel-mix");

mix.webpackConfig({
    resolve: {
        extensions: [".js", ".vue", ".json"],
        alias: {
            "@": __dirname + "/platform/themes/main/vue",
            "@core": __dirname + "/platform/themes/main/vue/core",
            "@modules": __dirname + "/platform/themes/main/vue/modules"
        }
    }
});

mix.version().webpackConfig({
    output: {
        chunkFilename: "js/chunks/[name].[hash].js"
    },
    module: {
        rules: [{ test: /\.txt$/, use: "raw-loader" }]
    }
});

mix.setPublicPath("public")
    .js("platform/themes/main/vue/core/app.js", "public/themes/main/js/app.js")
    .sass(
        "platform/themes/main/public/sass/app.scss",
        "public/themes/main/css/app.css"
    );
