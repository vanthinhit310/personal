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
mix.disableNotifications();
mix.version().webpackConfig({
    output: {
        chunkFilename: "js/chunks/[name].[hash].js"
    }
});

mix.setPublicPath("public")
    .js("platform/themes/main/vue/core/app.js", "public/themes/main/js/app.js").vue()
    .sass(
        "platform/themes/main/public/sass/app.scss",
        "public/themes/main/css/app.css"
    )
    .copyDirectory('platform/themes/main/public/img', 'public/themes/main/img');
