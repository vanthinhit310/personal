import Vue from "vue";

export default Vue.extend({
    template: `
        <el-tag :type="type" effect="dark">{{ text }}</el-tag>
    `,
    computed: {
        type() {
            switch (this.params.data.status) {
                case "NEW":
                    return "primary";

                case "COMPLETED":
                    return "success";

                case "IN PROGRESS":
                    return "warning";

                case "MISSED DEADLINE":
                    return "info";
            }
        },
        text() {
            return _.get(this.params.data, "status", "");
        }
    }
});
