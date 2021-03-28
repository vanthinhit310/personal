<template>
    <main-layout>
        <Content>
            <template v-slot:content>
                <div class="right-content">
                    <div class="wrap">
                        <div class="wrap_title">
                            <h1 class="wrap_title-text">Task Management</h1>
                            <span class="wrap_title-count">Total ({{ resourceCount }})</span> <el-button type="info" @click="fetchData" size="mini" icon="el-icon-refresh" circle></el-button>
                        </div>
                        <Toolbar @afterBulkDestroy="handleAfterBulkDestroy" @export="handleExport" @visibleColumn="handleVisibleColumn" :idSelected="idSelected"></Toolbar>
                        <Table :isExport="isExport" @rowSelectedChange="handleRowSelectedChange" :columns="columns"></Table>
                    </div>
                </div>
            </template>
        </Content>
    </main-layout>
</template>

<script>
import MainLayout from '@core/layouts/MainLayout.vue';
import Content from '@core/layouts/Content.vue';
import Toolbar from './Components/Toolbar';
import Table from './Components/Table';
import {AgGridVue} from 'ag-grid-vue';
import {mapActions, mapMutations, mapGetters} from 'vuex';

export default {
    components: {
        MainLayout,
        Content,
        AgGridVue,
        Toolbar,
        Table,
    },
    data() {
        return {
            idSelected: [],
            columns: [],
            isExport: false,
        };
    },
    computed: {
        ...mapGetters({
            resources: 'todoList/getResources',
            currentUser: 'auth/getCurrentUser',
        }),
        resourceCount() {
            return this.resources.length || 0;
        },
    },
    /* created() {
        Echo.private(`member.${_.get(this.currentUser, 'id')}`).listen('.task.socket', async (response) => {
            if (!!response) {
                const {notificationId} = response;
                const {taskId} = response;
                const {type} = response;
                if (!!notificationId && !!taskId && type) {
                    await this.handleEventListenFromSocket(notificationId, taskId, type);
                }
            }
        });
    }, */
    async mounted() {
        this.fetchData();
    },
    methods: {
        ...mapActions('todoList', ['fetch', 'edit']),
        ...mapActions('notification', ['getNotification']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
            pushNotification: 'notification/pushResource',
            pushResource: 'todoList/pushResource',
            updateResource: 'todoList/updateResource',
            removeResource: 'todoList/removeResource',
        }),
        async fetchData() {
            try {
                this.setLoadingState(true);
                await this.fetch();
            } catch (err) {
                console.log(`err`, err);
            }
            this.setLoadingState(false);
        },
        handleRowSelectedChange(idSelected) {
            if (idSelected.length > 0) {
                this.idSelected = idSelected;
            } else {
                this.idSelected = [];
            }
        },
        handleVisibleColumn(columns) {
            this.columns = columns;
        },
        handleExport(value) {
            this.isExport = value;
        },
        handleAfterBulkDestroy() {
            this.idSelected = [];
        },
        async handleEventListenFromSocket(notificationId, taskId, type) {
            const response = await this.getNotification(notificationId);
            const notification = _.get(response, 'data.resource', '');

            if (notification) {
                await this.pushNotification(notification);
            }
            switch (type) {
                case 'created':
                    let response = await this.edit(taskId);
                    let task = _.get(response, 'data.resource', '');
                    if (!!task) {
                        await this.pushResource(task);
                    }
                    break;

                case 'updated':
                    let updatedResponse = await this.edit(taskId);
                    let updatedTask = _.get(updatedResponse, 'data.resource', '');
                    if (!!updatedTask) {
                        await this.updateResource(updatedTask);
                    }
                    break;

                case 'destroyed':
                    await this.removeResource(taskId);
                    break;
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
