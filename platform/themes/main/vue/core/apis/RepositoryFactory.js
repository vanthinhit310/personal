const files = require.context("@modules/", true, /\.repository.js$/i);

const repositories = {};

files.keys().forEach(file => {
    //geting moduleName and path of module
    const fileName = _.last(_.pull(file.split("/"), "."));
    const path = _.join(_.pull(file.split("/"), "."), "/");
    const moduleName = _.camelCase(_.head(fileName.split(".")));
    // register file context under module name
    repositories[moduleName] =
        require(`@modules/${path}`).default || require(`@modules/${path}`);
});

export const RepositoryFactory = {
    get: name => repositories[name]
};


// import Authentication from "@modules/Auth/Api/AuthenticationRepository";
// import TodoList from "@modules/TodoList/Api/TodoListRepository";
// import Dashboard from "@modules/Dashboard/Api/DashboardRepository";

// const repositories = {
//     authentication: Authentication,
//     todo: TodoList,
//     dashboard: Dashboard
// };

// console.log(repositories);
