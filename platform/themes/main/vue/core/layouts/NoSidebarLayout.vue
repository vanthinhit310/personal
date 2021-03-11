<template>
    <a-layout class="h100">
        <slot />
    </a-layout>
</template>

<script>
import Content from '@core/layouts/Content.vue';
export default {
    components: {
        Content,
    },
};
</script>

<style lang="scss" scoped></style>
