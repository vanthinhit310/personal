<template>
    <div class="sidebar">
        <a-layout-sider :style="{ height: '100%' }" breakpoint="lg" collapsed-width="0">
            <div class="logo" />
            <a-menu theme="dark" mode="inline" :default-selected-keys="['1']">
                <a-menu-item key="1">
                    <router-link :to="{ name: 'dashboard' }"><a-icon type="user" /><span class="nav-text">Dashboard</span></router-link>
                </a-menu-item>
                <a-menu-item key="2">
                    <router-link :to="{ name: 'login' }"><a-icon type="video-camera" /><span class="nav-text">Login</span></router-link>
                </a-menu-item>
            </a-menu>
        </a-layout-sider>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped>
.logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}
</style>
