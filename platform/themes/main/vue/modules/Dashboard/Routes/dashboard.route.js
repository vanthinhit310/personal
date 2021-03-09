const routes = [
    {
        path: "/",
        component: "Dashboard/Index.vue",
        name: "dashboard",
        authorize: { requiredAuth: false }
    }
];

export default routes;
