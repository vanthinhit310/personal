import Vue from "vue";

export default Vue.extend({
    template: `
        <el-tag type="success" effect="plain">This work is assigned to 5 members</el-tag>
    `,
    data: function() {
        return {
            value: null
        };
    }
});
