<template>
    <a-layout id="components-layout-demo-responsive">
        <left-sidebar></left-sidebar>
        <a-layout>
            <Header />
            <a-spin tip="Processing..." :wrapperClassName="'page-loading'" size="large" :spinning="loading" :delay="100">
                <a-icon slot="indicator" type="loading" spin />
                <slot />
            </a-spin>
            <Footer />
        </a-layout>
    </a-layout>
</template>

<script>
import Header from '@core/layouts/Header';
import Footer from '@core/layouts/Footer';
import Content from '@core/layouts/Content';
import LeftSidebar from '@core/layouts/LeftSidebar';
import { mapGetters } from 'vuex';
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
