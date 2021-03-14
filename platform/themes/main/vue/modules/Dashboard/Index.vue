<template>
    <main-layout>
        <Content>
            <template v-slot:content>
                <h1>Here might be a page title</h1>
            </template>
        </Content>
    </main-layout>
</template>

<script>
import MainLayout from '@core/layouts/MainLayout.vue';
import Content from '@core/layouts/Content.vue';
export default {
    components: {
        MainLayout,
        Content,
    },
};
</script>

<style lang="scss" scoped></style>
