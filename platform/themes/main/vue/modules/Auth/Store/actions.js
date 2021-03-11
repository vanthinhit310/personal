import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const AuthRepository = RepositoryFactory.get("authentication");

export default {
    async login({ dispatch, state, commit }, formData) {
        const response = await AuthRepository.login(formData);
        const { token } = _.get(response, "data", "");
        if (!!token) {
            localStorage.setItem("accessToken", token);
        }

        return response;
    },
    async me({ dispatch, state, commit }) {
        const response = await AuthRepository.me();
        const user = _.get(response, "data", "");
        if (!!user) {
            commit("setCurrentUser", user);
        }

        return response;
    }
};
