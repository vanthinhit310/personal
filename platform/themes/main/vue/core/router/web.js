const files = require.context("@modules/", true, /\.route.js$/i);

const prefix = "";

let moduleRouters = [];

files.keys().forEach(key => {
    const name = _.join(_.pull(key.split("/"), "."), "/");
    moduleRouters = [...moduleRouters, ...require(`@modules/${name}`).default];
});

const routes = [...moduleRouters].map(o => {
    return generateRoutes(o);
});

function generateRoutes(o, pathPrefix = "") {
    const { path, component, name, authorize, children, redirect } = o;
    let orginal = {
        path: prefix + pathPrefix + path,
        name
    };
    if (!!component) {
        orginal = {
            ...orginal,
            component: () => import(`@modules/${component}`)
        };
    }
    if (!!redirect) {
        orginal = {
            ...orginal,
            redirect
        };
    }
    if (!!children && children instanceof Array) {
        orginal = {
            ...orginal,
            children: children.map(c => {
                return generateRoutes(c, path);
            })
        };
    }
    if (!!authorize) {
        orginal = {
            ...orginal,
            meta: authorize
        };
    }
    return orginal;
}

export default routes;
