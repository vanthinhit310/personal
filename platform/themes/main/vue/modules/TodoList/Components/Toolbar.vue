<template>
    <div class="wrap_action">
        <div class="wrap_action_left">
            <div class="wrap_action_item searchbox">
                <el-input class="searchbox_input" placeholder="Search" v-model="search" clearable> </el-input>
                <el-button icon="el-icon-search"></el-button>
            </div>
        </div>
        <Form :visible="visible" @closeForm="handleCloseForm"/>
        <div class="wrap_action_right">
            <el-button type="danger" icon="el-icon-delete">Remove (7)</el-button>
            <el-button type="primary" icon="el-icon-download">Export</el-button>
            <el-button type="success" @click="handleOpenForm" icon="el-icon-plus">Create task</el-button>
            <el-button icon="el-icon-s-tools"></el-button>
        </div>
    </div>
</template>

<script>
import Form from './Form';
export default {
    components: {
        Form,
    },
    data() {
        return {
            search: '',
            visible: false,
        };
    },
    methods: {
        handleOpenForm() {
            this.visible = true;
        },
        handleCloseForm() {
            this.visible = false;
        },
    },
};
</script>

<style lang="scss" scoped></style>
