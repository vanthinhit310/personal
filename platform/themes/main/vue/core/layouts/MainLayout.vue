<template>
    <a-layout class="h100" id="components-layout-demo-responsive">
        <left-sidebar></left-sidebar>
        <a-layout class="h100">
            <Header />
            <slot />
        </a-layout>
    </a-layout>
</template>

<script>
import Header from '@core/layouts/Header';
import Footer from '@core/layouts/Footer';
import Content from '@core/layouts/Content';
import LeftSidebar from '@core/layouts/LeftSidebar';
import {mapActions, mapMutations, mapGetters} from 'vuex';
export default {
    components: {
        Header,
        Footer,
        Content,
        LeftSidebar,
    },
    computed: {
        ...mapGetters({
            loading: 'dashboard/getLoadingState',
            currentUser: 'auth/getCurrentUser',
        }),
    },
    created() {
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
    },
    methods: {
        ...mapActions('todoList', ['edit']),
        ...mapActions('notification', ['getNotification']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
            pushNotification: 'notification/pushResource',
            pushResource: 'todoList/pushResource',
            updateResource: 'todoList/updateResource',
            removeResource: 'todoList/removeResource',
        }),
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
