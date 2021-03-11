import state from "@modules/Auth/Store/state.js";
import getters from "@modules/Auth/Store/getters.js";
import mutations from "@modules/Auth/Store/mutations.js";
import actions from "@modules/Auth/Store/actions.js";

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
