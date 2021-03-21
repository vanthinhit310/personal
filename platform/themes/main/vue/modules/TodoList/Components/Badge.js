import Vue from "vue";

export default Vue.extend({
    template: `
        <el-tag type="success" effect="plain">{{ value }}</el-tag>
    `,
    computed: {
        value() {
            if (
                this.params.data.members instanceof Array &&
                this.params.data.members.length != 0
            ) {
                return `${this.params.data.members.length} members`;
            }
            return "";
        }
    }
});
