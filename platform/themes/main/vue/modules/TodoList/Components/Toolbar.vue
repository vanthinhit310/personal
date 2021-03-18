<template>
    <div class="wrap_action">
        <div class="wrap_action_left">
            <div class="wrap_action_item searchbox">
                <el-input class="searchbox_input" placeholder="Search" v-model="search" clearable> </el-input>
                <el-button icon="el-icon-search"></el-button>
            </div>
        </div>
        <div class="wrap_action_right">
            <el-button type="danger" icon="el-icon-delete">Remove (7)</el-button>
            <el-button type="primary" icon="el-icon-download">Export</el-button>
            <el-button type="success" icon="el-icon-plus">Create task</el-button>
            <el-button icon="el-icon-s-tools"></el-button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            search: '',
        };
    },
};
</script>

<style lang="scss" scoped></style>
