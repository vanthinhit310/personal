import state from "@modules/TodoList/Store/state.js";
import getters from "@modules/TodoList/Store/getters.js";
import mutations from "@modules/TodoList/Store/mutations.js";
import actions from "@modules/TodoList/Store/actions.js";

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
