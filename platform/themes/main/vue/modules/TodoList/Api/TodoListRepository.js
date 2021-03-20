import axiosClient from "@core/apis/axiosClient.js";
const prefix = "todo";
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
    }
};
