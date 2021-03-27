import Authentication from "@modules/Auth/Api/AuthenticationRepository";
import TodoList from "@modules/TodoList/Api/TodoListRepository";
import Dashboard from "@modules/Dashboard/Api/DashboardRepository";

const repositories = {
    authentication: Authentication,
    todo: TodoList,
    dashboard: Dashboard
};

export const RepositoryFactory = {
    get: name => repositories[name]
};
