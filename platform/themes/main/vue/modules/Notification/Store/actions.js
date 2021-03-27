import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const NotificationRepository = RepositoryFactory.get("notification");
export default {
    async fetchNotification({ dispatch, state, commit }) {
        const response = await NotificationRepository.fetch();
        const resources = _.get(response, "data.resources");
        if (!!resources) {
            commit("setNotifications", resources);
        }
        return response;
    }
};
