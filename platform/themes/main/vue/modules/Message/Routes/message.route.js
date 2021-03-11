const routes = [
    {
        path: "/messages",
        component: "Message/Index.vue",
        name: "message",
        authorize: { requiredAuth: true }
    }
];

export default routes;
