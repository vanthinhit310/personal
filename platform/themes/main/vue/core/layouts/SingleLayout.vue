<template>
    <a-layout class="h100" v-loading="loading" element-loading-text="Processing..." element-loading-spinner="el-icon-loading" element-loading-background="rgba(255, 255, 255, 0.9)">
        <slot />
    </a-layout>
</template>

<script>
import Content from '@core/layouts/Content.vue';
import { mapGetters } from 'vuex';
export default {
    components: {
        Content,
    },
    computed: {
        ...mapGetters({
            loading: 'dashboard/getLoadingState',
        }),
    },
};
</script>

<style lang="scss" scoped></style>
