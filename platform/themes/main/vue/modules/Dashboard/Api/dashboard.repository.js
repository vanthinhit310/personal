import axiosClient from "@core/apis/axiosClient.js";
const prefix = "/notification";
export default {
    fetch() {
        return axiosClient.get(`${prefix}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    }
};
