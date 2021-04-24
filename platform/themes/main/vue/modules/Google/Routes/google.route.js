const routes = [
    {
        path: "/api-google",
        component: "Google/Index.vue",
        name: "google",
        authorize: {requiredAuth: true},
        children: [{
            path: '/photo',
            name: 'google.photo',
            component: "Google/Pages/GooglePhoto/Index.vue",
        }]
    }
];

export default routes;
