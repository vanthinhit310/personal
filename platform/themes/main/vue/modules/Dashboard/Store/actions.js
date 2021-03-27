import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const DashboardRepository = RepositoryFactory.get("dashboard");
export default {
    handleLoading({ dispatch, state, commit }, status) {
        commit("setLoadingState", status);
    }
};
