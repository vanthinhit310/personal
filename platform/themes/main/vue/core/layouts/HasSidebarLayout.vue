<template>
    <a-layout id="components-layout-demo-responsive">
        <left-sidebar></left-sidebar>
        <a-layout>
            <Header />
            <slot/>
            <Footer />
        </a-layout>
    </a-layout>
</template>

<script>
import Header from '@core/layouts/Header';
import Footer from '@core/layouts/Footer';
import Content from '@core/layouts/Content';
import LeftSidebar from '@core/layouts/LeftSidebar';
export default {
    components: {
        Header,
        Footer,
        Content,
        LeftSidebar
    },
};
</script>

<style lang="scss" scoped></style>
