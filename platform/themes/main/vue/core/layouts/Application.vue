<template>
    <section class="application h100">
        <transition name="slide-fade">
            <router-view />
        </transition>
    </section>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
export default {
    computed: {
        ...mapGetters({
            loading: 'dashboard/getLoadingState',
        }),
    },
    methods: {
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        })
    },
    mounted() {},
};
</script>

<style lang="scss" scoped>
#components-layout-demo-responsive .logo {
    height: 32px;
    background: rgba(255, 255, 255, 0.2);
    margin: 16px;
}
</style>
