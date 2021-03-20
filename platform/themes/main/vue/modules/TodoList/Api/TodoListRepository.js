import axiosClient from "@core/apis/axiosClient.js";
const prefix = "/todo";
export default {
    fetchMembers({ query, limit }) {
        return axiosClient.get(
            "members",
            { params: { query, limit } },
            {
                headers: {
                    Authorization:
                        "Bearer " + localStorage.getItem("accessToken")
                }
            }
        );
    },
    fetch() {
        return axiosClient.get(prefix, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    },
    create(param) {
        return axiosClient.post(`${prefix}/create`, param, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
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
        return axiosClient.post(`${prefix}/bulk-delete`, arrayId, {
            headers: {
                Authorization: "Bearer " + localStorage.getItem("accessToken")
            }
        });
    }
};
