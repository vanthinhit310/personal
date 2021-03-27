<template>
    <section class="application h100">
        <vue-progress-bar />
            <router-view element-loading-text="processing..." v-loading.fullscreen.lock="loading"/>
    </section>
</template>

<script>
import {mapGetters, mapMutations} from 'vuex';
export default {
    computed: {
        ...mapGetters({
            loading: 'dashboard/getLoadingState',
        }),
    },
    methods: {
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
    },
    mounted() {},
};
</script>

<style lang="scss" scoped></style>
