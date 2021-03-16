<template>
    <a-layout class="h100">
        <a-spin tip="Processing..." :wrapperClassName="'page-loading'" size="large" :spinning="loading" :delay="100">
            <a-icon slot="indicator" type="loading" spin />
            <slot />
        </a-spin>
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
