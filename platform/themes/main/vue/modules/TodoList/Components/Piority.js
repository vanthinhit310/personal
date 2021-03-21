import Vue from "vue";

export default Vue.extend({
    template: `
        <el-tag :type="type" effect="dark">{{ text }}</el-tag>
    `,
    computed: {
        type() {
            switch (this.params.data.piority) {
                case "LOW":
                    return "warning";

                case "NORMAL":
                    return "success";

                case "HIGH":
                    return "danger";
            }
        },
        text() {
            return _.get(this.params.data, "piority", "");
        }
    }
});
