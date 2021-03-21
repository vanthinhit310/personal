import Vue from "vue";
import Action from "./ActionComponent.vue";

export default Vue.extend({
    template: `
        <Action :value="value" @removeResource="handleClickRemove" @editResource="handeClickEdit">
            <slot />
        </Action>
    `,
    components: {
        Action
    },
    computed: {
        value() {
            const { data } = this.params;
            if (!!data) return data;
            return null;
        }
    },
    methods: {
        async handleClickRemove(e) {
            const self = this;

            this.$confirm(
                "This will permanently delete the resource. Continue?",
                "Warning",
                {
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    type: "warning"
                }
            )
                .then(() => {
                    const { data, rowIndex } = self.params;
                    self.params.context.componentParent.contextParentMethod({
                        data,
                        rowIndex,
                        type: "destroy"
                    });
                })
                .catch(() => {});
        },
        handeClickEdit() {
            const { data, rowIndex } = this.params;
            this.params.context.componentParent.contextParentMethod({
                data,
                rowIndex,
                type: "edit"
            });
        }
    }
});
