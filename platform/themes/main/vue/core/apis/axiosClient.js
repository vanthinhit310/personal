import axios, { CancelToken } from "axios";
import queryString from "query-string";
import app from "@core/app.js";

let cancel = [];

const axiosClient = axios.create({
    baseURL: "/api/v1/",
    headers: { "content-type": "application/json" },
    paramsSerializer: params => queryString.stringify(params)
});
axiosClient.interceptors.request.use(async config => {
    let requestName = config.url.replace("/", "_");
    // let's see, if i get the last one here requestName， just cancel the last request
    if (requestName) {
        if (cancel[requestName] && cancel[requestName].cancel) {
            cancel[requestName].cancel(`Cancel request ${requestName} !!`);
        }
        config.cancelToken = new CancelToken(c => {
            cancel[requestName] = {};
            cancel[requestName].cancel = c;
        });
    }
    config.headers["Authorization"] = `Bearer ${localStorage.getItem("accessToken")}`;
    // app.$Progress.start();
    return {
        ...config
    };
});
axiosClient.interceptors.response.use(
    response => {
        // app.$Progress.finish();
        if (response && response.data) {
            const message = _.get(response, "data.message");

            if (!!message) {
                app.$notification.success({
                    message: "Notification System",
                    description: message
                });
            }
            return response.data;
        }
        return response;
    },
    error => {
        if (axios.isCancel(error)) {
            console.log("Request canceled", error);
        } else {
            if (!!error.response) {
                const status = _.get(error, "response.status", 400);
                const message = _.get(error, "response.data.message", "");

                switch (status) {
                    case 401:
                        if (!localStorage.getItem("accessToken")) break;

                        app.$notification.error({
                            message: "Notification System",
                            description: message
                        });

                        localStorage.setItem("accessToken", "");

                        app.$router.push({
                            name: "login",
                            query: {
                                redirect:
                                    app.$route.name == "login"
                                        ? "/"
                                        : app.$route.fullpath
                            }
                        });
                        break;

                    case 403:
                        app.$router.push({
                            name: "dashboard"
                        });
                        app.$notification.error({
                            message: "Notification System",
                            description: message
                        });
                        break;

                    case 422:
                        const errors = _.get(error, "response.data.errors", "");
                        if (!!message)
                            app.$notification.error({
                                message: "Notification System",
                                description: message
                            });

                        if (!!errors)
                            app.$notification.error({
                                message: "Notification System",
                                description:
                                    Object.values(errors)[0][0] ||
                                    "Validator errors!"
                            });
                        break;

                    default:
                        app.$notification.error({
                            message: "Notification System",
                            description: message
                        });
                        break;
                }
            }
        }

        throw error;
    }
);
export default axiosClient;
