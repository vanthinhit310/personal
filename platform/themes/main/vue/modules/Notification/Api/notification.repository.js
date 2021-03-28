import axiosClient from "@core/apis/axiosClient.js";
const prefix = "/notification";
export default {
    fetch(page = 1) {
        return axiosClient.get(
            `${prefix}`,
            { params: { page } },
            {
                headers: {
                    Authorization:
                        "Bearer " + localStorage.getItem("accessToken")
                }
            }
        );
    },
    edit(id) {
        return axiosClient.get(`${prefix}/edit/${id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    },
    update({ id, param }) {
        return axiosClient.post(`${prefix}/edit/${id}`, param, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    },
    destroy(id) {
        return axiosClient.delete(`${prefix}/${id}`, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    },
    bulkDelete(arrayId) {
        return axiosClient.post(
            `${prefix}/bulk-delete`,
            { ids: arrayId },
            {
                headers: {
                    Authorization:
                        "Bearer " + localStorage.getItem("accessToken")
                }
            }
        );
    }
};
