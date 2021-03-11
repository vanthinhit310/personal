<template>
    <div class="header">
        <a-layout-header :style="{ background: '#FFF', padding: '5px 15px' }">
            <div class="header-content">
                <a-badge count="0" show-zero class="notification-icon">
                    <a-icon type="bell" :style="{ fontSize: '20px' }" />
                </a-badge>
                <a-dropdown class="user-dropdown">
                    <span><a-avatar :size="40" src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png" /> Anonymous</span>
                    <a-menu slot="overlay">
                        <a-menu-item>
                            <a href="javascript:;"><a-icon type="profile" /> Profile</a>
                        </a-menu-item>
                        <a-menu-item>
                            <a href="javascript:;"><a-icon type="logout" /> Logout</a>
                        </a-menu-item>
                    </a-menu>
                </a-dropdown>
            </div>
        </a-layout-header>
    </div>
</template>

<script>
export default {};
</script>

<style lang="scss" scoped></style>
