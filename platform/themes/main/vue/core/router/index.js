import Vue from "vue";
import VueRouter from "vue-router";
import routes from "./web";
import store from "@core/store/index";
import NProgress from "nprogress";
import "nprogress/nprogress.css";
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

router.beforeEach(async (to, from, next) => {
    const { getters, dispatch } = store;
    NProgress.start();
    await dispatch("dashboard/handleLoading", true);
    //chuyển hướng đến trang đăng nhập nếu chưa đăng nhập và cố gắng truy cập trang bị hạn chế
    let { requiredAuth } = to.meta;

    if (requiredAuth) {
        let isAuthentication = false;

        if (!localStorage.getItem("accessToken")) {
            //chưa đăng nhập nên chuyển hướng đến trang đăng nhập với url trả về
            return next({ name: "login", query: { redirect: to.fullPath } });
        }

        isAuthentication = getters["auth/isAuthentication"];
        if (!isAuthentication) {
            await dispatch("auth/me");
            isAuthentication = getters["auth/isAuthentication"];
        }
    }
    if (requiredAuth == false) {
        if (localStorage.getItem("accessToken")) {
            //nếu đã đăng nhập rồi mà lại vào các url không yêu cầu auth thì sẽ redirect về dashboard
            return next({ name: "dashboard" });
        }
    }

    next();
});
router.afterEach(async () => {
    const { dispatch } = store;
    await dispatch("dashboard/handleLoading", false);
    NProgress.done();
});

export default router;
