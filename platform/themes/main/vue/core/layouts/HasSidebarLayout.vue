<template>
    <a-layout id="components-layout-demo-responsive">
        <Sidebar />
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
import Sidebar from '@core/layouts/Sidebar';
import Content from '@core/layouts/Content';
export default {
    components: {
        Header,
        Footer,
        Sidebar,
        Content,
    },
};
</script>

<style lang="scss" scoped></style>
