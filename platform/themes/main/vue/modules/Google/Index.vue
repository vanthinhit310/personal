<template>
    <main-layout>
        <Content>
            <template v-slot:content>
                <div class="right-content">
                    <router-view></router-view>
                </div>
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

<style scoped>

</style>
