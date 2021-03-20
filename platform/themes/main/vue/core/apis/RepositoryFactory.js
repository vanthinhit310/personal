import Authentication from "@modules/Auth/Api/AuthenticationRepository";
import TodoList from "@modules/TodoList/Api/TodoListRepository";

const repositories = {
    authentication: Authentication,
    todo: TodoList,
};

export const RepositoryFactory = {
    get: name => repositories[name]
};
