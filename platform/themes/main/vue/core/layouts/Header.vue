<template>
    <div class="header">
        <a-layout-header :style="{background: '#f1f3f4'}">
            <div class="header-content">
                <el-popover placement="bottom" width="350" trigger="click">
                    <ul class="infinite-list notification" v-infinite-scroll="load" style="overflow: auto">
                        <li :key="i" v-for="i in count" class="infinite-list-item">
                            <router-link to="javascript:;" class="notification_item unread">
                                <el-avatar class="notification_item--avatar" icon="el-icon-user-solid"></el-avatar>
                                <div class="notification_item--content">
                                    <div class="message">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore, deleniti deserunt, non, sed quia blanditiis ea soluta</div>
                                    <div class="diff-time">1 hour ago</div>
                                </div>
                            </router-link>
                        </li>
                    </ul>
                    <el-badge slot="reference" :value="0" class="notification-icon">
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
import vueCustomScrollbar from 'vue-custom-scrollbar';
import 'vue-custom-scrollbar/dist/vueScrollbar.css';
export default {
    data() {
        return {
            count: 2,
            settings: {
                suppressScrollY: false,
                suppressScrollX: false,
                wheelPropagation: false,
            },
        };
    },
    components: {
        vueCustomScrollbar,
    },
    computed: {
        ...mapGetters({
            user: 'auth/getCurrentUser',
            avatar: 'auth/getAvatar',
        }),
    },
    methods: {
        ...mapActions('auth', ['logout']),
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
