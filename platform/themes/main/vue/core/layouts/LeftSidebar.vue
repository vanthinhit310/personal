<template>
    <div class="sidebar">
        <a-layout-sider :style="{ height: '100%', width: '250px', maxWidth: '250px', minWidth: '250px' }" breakpoint="lg" collapsed-width="0">
            <div class="logo">
                <router-link :to="{ name: 'dashboard' }"><img src="/themes/main/imgs/logo.png" alt="Logo" /></router-link>
            </div>
            <a-menu theme="dark" mode="inline" :inlineIndent="0">
                <template v-for="(menu, index) in menus">
                    <a-menu-item v-if="!menu.subs" :key="index + 1">
                        <router-link :to="_.get(menu, 'link')">
                            <a-icon v-if="menu.icon" :type="_.get(menu, 'icon')" /><span class="nav-text">{{ _.get(menu, 'title') }}</span>
                        </router-link>
                    </a-menu-item>
                    <a-sub-menu v-else :key="`sub${index}`">
                        <span class="sub-menu-title" slot="title">
                            <a-icon v-if="menu.icon" :type="_.get(menu, 'icon')" /><span>{{ _.get(menu, 'title') }}</span>
                        </span>
                        <a-menu-item v-for="(sub, i) in menu.subs" :key="`${i + 1}`">
                            <router-link :to="_.get(sub, 'link')">
                                <a-icon v-if="sub.icon" :type="_.get(sub, 'icon')" /><span class="nav-text">{{ _.get(sub, 'title') }}</span>
                            </router-link>
                        </a-menu-item>
                    </a-sub-menu>
                </template>
            </a-menu>
        </a-layout-sider>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            menuSelected: 1,
        };
    },
    computed: {
        ...mapGetters({
            menus: 'dashboard/getSidebarMenu',
        }),
    },
    methods: {
        handleMenuSelected({ item, key, keyPath }) {
            console.log(key);
            this.menuSelected = key;
        },
    },
};
</script>

<style lang="scss" scoped></style>
