<template>
    <div class="header">
        <a-layout-header :style="{background: '#f1f3f4'}">
            <div class="header-content">
                <el-popover placement="bottom" width="350" trigger="click">
                    <ul class="infinite-list notification" v-infinite-scroll="load" style="overflow: auto">
                        <li :key="index" v-for="(item, index) in notifications" class="infinite-list-item">
                            <router-link :disabled="true" to="javascript:;" class="notification_item unread">
                                <el-avatar class="notification_item--avatar" :src="getAvatar(item)"></el-avatar>
                                <div class="notification_item--content">
                                    <div class="message" v-text="_.get(item, 'message')"></div>
                                    <div class="diff-time" v-text="_.get(item, 'time')"></div>
                                </div>
                            </router-link>
                        </li>
                    </ul>
                    <el-badge slot="reference" :value="notificationCount" class="notification-icon">
                        <i class="el-icon-bell" :style="{fontSize: '25px'}"></i>
                    </el-badge>
                </el-popover>

                <a-dropdown class="user-dropdown">
                    <span> <el-avatar class="user_avatar" :size="45" :src="avatar"></el-avatar> {{ _.get(user, 'fullname', '') }} </span>
                    <a-menu slot="overlay">
                        <a-menu-item>
                            <a href="javascript:;"><a-icon type="profile" /> Profile</a>
                        </a-menu-item>
                        <a-menu-item>
                            <a href="javascript:;" @click="handleLogout"><a-icon type="logout" /> Logout</a>
                        </a-menu-item>
                    </a-menu>
                </a-dropdown>
            </div>
        </a-layout-header>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex';
import mixins from '@core/helpers/mixins.js';
export default {
    mixins: [mixins],
    data() {
        return {
            count: 2,
        };
    },
    computed: {
        ...mapGetters({
            user: 'auth/getCurrentUser',
            avatar: 'auth/getAvatar',
            notifications: 'notification/getResources',
        }),
        notificationCount() {
            if (!!this.notifications) {
                return this.notifications.length;
            }
            return 0;
        },
    },
    async mounted() {
        try {
            const {notifications} = this;
            if (notifications instanceof Array && notifications.length == 0) {
                await this.fetch();
            }
        } catch (err) {}
    },
    methods: {
        ...mapActions('auth', ['logout']),
        ...mapActions('notification', ['fetch']),
        async handleLogout() {
            try {
                await this.logout();
                this.$router.push({name: 'login', query: {redirect: this.$route.fullpath}});
            } catch (err) {
                console.log(err);
            }
        },
        load() {
            this.count += 2;
        },
    },
};
</script>

<style lang="scss" scoped></style>
