import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const DashboardRepository = RepositoryFactory.get("dashboard");
export default {
    handleLoading({ dispatch, state, commit }, status) {
        commit("setLoadingState", status);
    },
    async fetchNotification({ dispatch, state, commit }) {
        const response = await DashboardRepository.fetch();
        const resources = _.get(response, "data.resources");
        if (!!resources) {
            commit("setNotifications", resources);
        }
        return response;
    }
};
