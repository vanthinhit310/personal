const routes = [
    {
        path: "/",
        component: "Dashboard/Index.vue",
        name: "dashboard",
        authorize: { requiredAuth: true }
    }
];

export default routes;
