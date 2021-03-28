import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const NotificationRepository = RepositoryFactory.get("notification");
export default {
    async fetch({ dispatch, state, commit }, page) {
        const response = await NotificationRepository.fetch(page);
        const resources = _.get(response, "data.resources");
        if (!!resources) {
            commit("setResources", resources);
        }
        return response;
    },
    async getNotification({ dispatch, state, commit }, id) {
        return await NotificationRepository.edit(id);
    },
    async update({ dispatch, state, commit }, { id, param }) {
        const response = await NotificationRepository.update({ id, param });
        const resource = _.get(response, "data.resource", []);
        if (!!resource) {
            commit("updateResource", resource);
        }
        return response;
    },

};
