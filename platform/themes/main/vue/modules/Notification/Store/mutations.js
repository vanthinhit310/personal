import mixin from "@core/helpers/mixins.js";

export default {
    setResources(state, resources) {
        state.resources = resources;
    },
    pushResource(state, resource) {
        const { resources } = state;
        state.resources = [resource, ...resources];
        mixin.methods.playSoundOfNotify();
    },
    setResource(state, resource) {
        state.resource = resource;
    },
    updateResource(state, resource) {
        const { resources } = state;
        const index = _.findIndex(resources, function(o) {
            return o.id == _.get(resource, "id", 0);
        });
        if (index != -1) {
            state.resources = [
                ...resources.slice(0, index),
                resource,
                ...resources.slice(index + 1)
            ];
        }
    },
    removeResource(state, id) {
        const { resources } = state;
        const index = _.findIndex(resources, function(o) {
            return o.id == id;
        });
        if (index != -1) {
            state.resources = [
                ...resources.slice(0, index),
                ...resources.slice(index + 1)
            ];
        }
    },
    handleBulkDestroy(state, arrayId) {
        const { resources } = state;
        const removed = _.remove(resources, function(o) {
            return arrayId.includes(o.id);
        });
        state.resources = [...resources];
    }
};
