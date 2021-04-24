import axiosClient from "@core/apis/axiosClient.js";
export default {
    login(formData) {
        return axiosClient.post("login", formData);
    },
    googleLogin(formData) {
        return axiosClient.post("login/google", formData);
    },
    logout() {
        return axiosClient.get("logout", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    },
    me() {
        return axiosClient.get("me", {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    }
};
