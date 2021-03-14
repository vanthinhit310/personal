export default {
    handleLoading({ dispatch, state, commit }, status) {
        commit("setLoadingState", status);
    }
};
