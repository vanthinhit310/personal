const routes = [
    {
        path: "/login",
        component: "Auth/Index.vue",
        name: "login",
        authorize: { requiredAuth: false }
    }
];

export default routes;
