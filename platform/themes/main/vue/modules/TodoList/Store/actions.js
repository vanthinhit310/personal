import { RepositoryFactory } from "@core/apis/RepositoryFactory";

const TodoRepository = RepositoryFactory.get("todo");

export default {
    async fetchMembers({ dispatch, state, commit }, { query, limit }) {
        return await TodoRepository.fetchMembers({ query, limit });
    }
};
