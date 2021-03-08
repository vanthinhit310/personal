<template>
    <section class="application">
        <a-spin>
            <a-icon slot="indicator" type="loading" style="font-size: 24px" spin />
            <transition name="slide-fade">
                <router-view />
            </transition>
        </a-spin>
    </section>
</template>

<script>
export default {

};
</script>

<style lang="scss" scoped></style>
