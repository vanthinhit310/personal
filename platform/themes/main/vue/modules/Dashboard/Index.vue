<template>
    <has-sidebar-layout>
        <Content>
            <template v-slot:content>
                <h1>Here might be a page title</h1>
            </template>
        </Content>
    </has-sidebar-layout>
</template>

<script>
import HasSidebarLayout from '@core/layouts/HasSidebarLayout.vue';
import Content from '@core/layouts/Content.vue';
export default {
    components: {
        HasSidebarLayout,
        Content,
    },
};
</script>

<style lang="scss" scoped></style>
