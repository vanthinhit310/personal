import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const GoogleRepository = RepositoryFactory.get("google");

export default {
    async getMediaItems(
        { dispatch, state, commit },
        { accessToken, pageToken }
    ) {
        return await GoogleRepository.getMediaItems(accessToken, pageToken);
    },
    async filterMediaItems(
        { dispatch, state, commit },
        { accessToken, pageToken, filterParams }
    ) {
        return await GoogleRepository.filterMediaItems(
            accessToken,
            pageToken,
            filterParams
        );
    }
};
