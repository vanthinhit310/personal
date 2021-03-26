<template>
    <div class="header">
        <a-layout-header :style="{background: '#f1f3f4'}">
            <div class="header-content">
                <el-dropdown :hide-on-click="false" trigger="click">
                    <el-badge :value="0" class="notification-icon">
                        <i class="el-icon-bell" :style="{fontSize: '25px'}"></i>
                    </el-badge>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item class="clearfix"> comments comments comments comments </el-dropdown-item>
                        <el-dropdown-item class="clearfix"> comments comments comments comments </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
                <!-- <a-badge count="0" show-zero class="notification-icon">
                    <a-icon type="bell" :style="{fontSize: '20px'}" />
                </a-badge> -->
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
export default {
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
    },
};
</script>

<style lang="scss" scoped></style>
