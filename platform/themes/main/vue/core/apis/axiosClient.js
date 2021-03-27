"use strict";
import axios from "axios";
import queryString from "query-string";
import qs from "qs";
import app from "@core/app.js";

// Declare a Map to store the identification and cancellation functions for each request
const pending = new Map();

const addPending = config => {
    const url = [
        config.method,
        config.url,
        qs.stringify(config.params),
        qs.stringify(config.data)
    ].join("&");
    config.cancelToken =
        config.cancelToken ||
        new axios.CancelToken(cancel => {
            if (!pending.has(url)) {
                // If the current request does not exist in pending, add it
                pending.set(url, cancel);
            }
        });
};

const removePending = config => {
    const url = [
        config.method,
        config.url,
        qs.stringify(config.params),
        qs.stringify(config.data)
    ].join("&");
    if (pending.has(url)) {
        // If the current request identity exists in pending, you need to cancel the current request and remove it
        const cancel = pending.get(url);
        cancel(url);
        pending.delete(url);
    }
};
/**
 * Empty requests in pending (called on route jumps)
 */
export const clearPending = () => {
    for (const [url, cancel] of pending) {
        cancel(url);
    }
    pending.clear();
};

const genEmptyPromise = () => new Promise(() => {});

const axiosClient = axios.create({
    baseURL: "/api/v1/",
    headers: { "content-type": "application/json" },
    paramsSerializer: params => queryString.stringify(params)
});
axiosClient.interceptors.request.use(
    async config => {
        removePending(config); // Check previous requests to cancel before the request starts
        addPending(config); // Add current request to pending
        config.headers["Authorization"] = `Bearer ${localStorage.getItem(
            "accessToken"
        )}`;
        return {
            ...config
        };
    },
    error => {
        return Promise.reject(error);
    }
);

axiosClient.interceptors.response.use(
    response => {
        removePending(response.config);
        if (response && response.data) {
            const message = _.get(response, "data.message");

            if (!!message) {
                app.$notify.success({
                    title: "Notification System",
                    message: message
                });
            }
            return response.data;
        }
        return response;
    },
    error => {
        removePending(error.response.config);
        if (!!error.response) {
            const status = _.get(error, "response.status", 400);
            const message = _.get(error, "response.data.message", "");

            switch (status) {
                case 401:
                    if (!localStorage.getItem("accessToken")) break;

                    app.$notify.error({
                        title: "Notification System",
                        message: message
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
                    app.$notify.error({
                        title: "Notification System",
                        message: message
                    });
                    break;

                case 422:
                    const errors = _.get(error, "response.data.errors", "");
                    if (!!message)
                        app.$notify.error({
                            title: "Notification System",
                            message: message
                        });

                    if (!!errors)
                        app.$notify.error({
                            title: "Notification System",
                            message:
                                Object.values(errors)[0][0] ||
                                "Validator errors!"
                        });
                    break;

                default:
                    app.$notify.error({
                        title: "Notification System",
                        message: message
                    });
                    break;
            }
        }
        if (axios.isCancel(error)) {
            console.log("repeated request: " + error.message);
        } else {
            // handle error code
        }
        return Promise.reject(error);
    }
);
export default axiosClient;
