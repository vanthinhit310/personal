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
import {mapGetters} from 'vuex';
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
        }),
    },
};
</script>

<style lang="scss" scoped></style>
