const routes = [
    {
        path: "/tasks",
        component: "TodoList/Index.vue",
        name: "tasks",
        authorize: { requiredAuth: true }
    }
];

export default routes;
