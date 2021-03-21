<template>
    <div class="wrap_action">
        <div class="wrap_action_left">
            <div class="wrap_action_item searchbox">
                <el-input class="searchbox_input" placeholder="Search" v-model="search" clearable> </el-input>
                <el-button icon="el-icon-search"></el-button>
            </div>
        </div>
        <Form :visible="visible" :isUpdate="isUpdate" @closeForm="handleCloseForm" />
        <div class="wrap_action_right">
            <transition name="fade">
                <el-button @click="handleBulkDestroy" v-show="idSelected.length" type="danger" icon="el-icon-delete">Remove ({{ rowSelected }})</el-button>
            </transition>
            <el-button type="primary" icon="el-icon-download">Export</el-button>
            <el-button type="success" @click="handleOpenForm" icon="el-icon-plus">Create task</el-button>
            <el-button icon="el-icon-s-tools"></el-button>
        </div>
    </div>
</template>

<script>
import Form from './Form';
import {mapGetters, mapMutations, mapActions} from 'vuex';
export default {
    components: {
        Form,
    },
    props: ['idSelected'],
    data() {
        return {
            isUpdate: false,
            search: '',
            visible: false,
        };
    },
    computed: {
        ...mapGetters({
            resource: 'todoList/getResource',
        }),
        rowSelected() {
            return this.idSelected.length || 0;
        },
    },
    methods: {
        ...mapActions('todoList', ['bulkDestroy']),
        ...mapMutations({
            setResource: 'todoList/setResource',
            setLoadingState: 'dashboard/setLoadingState',
        }),
        handleOpenForm() {
            this.visible = true;
        },
        handleCloseForm() {
            this.visible = false;
            this.isUpdate = false;
            this.setResource('');
        },
        async handleBulkDestroy() {
            try {
                const self = this;
                self.$confirm('This will permanently delete the resource. Continue?', 'Warning', {
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    type: 'warning',
                })
                    .then(() => {
                        self.excuteBulkDestroy();
                    })
                    .catch(() => {});
            } catch (err) {
                console.log(`err`, err);
            }
        },
        async excuteBulkDestroy() {
            try {
                this.setLoadingState(true);
                await this.bulkDestroy(this.idSelected);
            } catch (err) {
                console.log(err);
            }
            this.setLoadingState(false);
        },
    },
    watch: {
        resource() {
            const {resource} = this;
            if (!!resource) {
                this.visible = true;
                this.isUpdate = true;
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
