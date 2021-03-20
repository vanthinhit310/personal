const files = require.context("@modules/", true, /\.store.js$/i);

const modules = {};

files.keys().forEach(file => {

    //geting moduleName and path of module
    const path = _.join(_.pull(file.split("/"), "."), "/");
    const moduleName = _.camelCase(_.head(_.pull(file.split("/"), ".")));
    console.log(moduleName);

    // register file context under module name
    modules[moduleName] = require(`@modules/${path}`).default || require(`@modules/${path}`);

    // override namespaced option
    modules[moduleName].namespaced = true;
});

export default modules;
