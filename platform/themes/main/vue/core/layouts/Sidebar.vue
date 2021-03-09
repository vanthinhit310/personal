<template>
    <div class="sidebar">
        <a-layout-sider :style="{ height: '100%' }" breakpoint="lg" collapsed-width="0">
            <div class="logo" />
            <a-menu theme="dark" mode="inline" :default-selected-keys="['1']">
                <a-menu-item key="1">
                    <a-icon type="user" />
                    <span class="nav-text">nav 1</span>
                </a-menu-item>
                <a-menu-item key="2">
                    <a-icon type="video-camera" />
                    <span class="nav-text">nav 2</span>
                </a-menu-item>
                <a-menu-item key="3">
                    <a-icon type="upload" />
                    <span class="nav-text">nav 3</span>
                </a-menu-item>
                <a-menu-item key="4">
                    <a-icon type="user" />
                    <span class="nav-text">nav 4</span>
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
