<template>
    <div class="sidebar">
        <a-layout-sider :style="{ height: '100%', backgroundColor: '#1a4463' }" breakpoint="lg" width="270" collapsed-width="0">
            <div class="logo">
                <router-link :to="{ name: 'dashboard' }"><img src="/themes/main/imgs/logo.png" alt="Logo" /></router-link>
            </div>
            <el-menu router :default-active="$route.path" :text-color="'#c7c7c7'" :active-text-color="'#fff'" :background-color="'#1a4463'" class="el-menu-vertical-demo">
                <template v-for="(menu, index) in menus">
                    <el-menu-item v-if="!menu.subs" :key="index + 1" :route="_.get(menu,'link', {})" :index="`${_.get(menu, 'path', '/')}`">
                        <i v-if="menu.icon" :class="_.get(menu, 'icon')"></i>
                        <span>{{ _.get(menu, 'title') }}</span>
                    </el-menu-item>
                    <el-submenu v-else :key="index + 1" :index="`${index + 1}`">
                        <template slot="title">
                            <i v-if="menu.icon" :class="_.get(menu, 'icon')"></i>
                            <span>{{ _.get(menu, 'title') }}</span>
                        </template>
                        <el-menu-item v-for="(sub, i) in menu.subs" :route="_.get(sub,'link', {})" :key="`sub${i + 1}`" :index="`${_.get(sub, 'path', '/')}`">
                            <i v-if="sub.icon" :class="_.get(sub, 'icon')"></i>
                            <span>{{ _.get(sub, 'title') }}</span>
                        </el-menu-item>
                    </el-submenu>
                </template>
            </el-menu>
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
