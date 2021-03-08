import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./web";
Vue.use(VueRouter);

const router = new VueRouter({
    mode: "history",
    routes: [
        ...routes,
        // otherwise redirect to home
        { path: "*", redirect: "/" }
    ],
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active"
});

export default router
