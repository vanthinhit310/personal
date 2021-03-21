import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const TodoRepository = RepositoryFactory.get("todo");

export default {
    async fetchMembers({ dispatch, state, commit }, { query, limit }) {
        return await TodoRepository.fetchMembers({ query, limit });
    },
    async fetch({ dispatch, state, commit }) {
        const response = await TodoRepository.fetch();
        const resources = _.get(response, "data.resources", []);
        if (!!resources) {
            commit("setResources", resources);
        }
        return response;
    },
    async create({ dispatch, state, commit }, param) {
        const response = await TodoRepository.create(param);
        const resource = _.get(response, "data.resource", []);
        if (!!resource) {
            commit("pushResource", resource);
        }
        return response;
    },
    async edit({ dispatch, state, commit }, id) {
        return await TodoRepository.edit(id);
    },
    async update({ dispatch, state, commit }, { id, param }) {
        const response = await TodoRepository.update({ id, param });
        const resource = _.get(response, "data.resource", []);
        if (!!resource) {
            commit("updateResource", resource);
        }
        return response;
    },
    async destroy({ dispatch, state, commit }, id) {
        const response = await TodoRepository.destroy(id);
        commit("removeResource", id);
        return response;
    },
    async bulkDestroy({ dispatch, state, commit }, arrayId) {
        const response = await TodoRepository.bulkDelete(arrayId);
        commit("handleBulkDestroy", arrayId);
        return response;
    }
};
