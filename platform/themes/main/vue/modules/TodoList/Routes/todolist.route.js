const routes = [
    {
        path: "/todo-list",
        component: "TodoList/Index.vue",
        name: "todo-list",
        authorize: { requiredAuth: true }
    }
];

export default routes;
