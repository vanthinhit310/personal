<template>
    <main-layout>
        <Content>
            <template v-slot:content>
                <div class="right-content">
                    <div class="wrap justify-content-flexstart">
                        <div class="wrap_title">
                            <h1 class="wrap_title-text">Covid-19 Tracking App</h1>
                        </div>
                        <div class="tracking-by-continent">
                            <tracking-by-continent></tracking-by-continent>
                        </div>
                    </div>
                </div>
            </template>
        </Content>
    </main-layout>
</template>

<script>
import MainLayout from '@core/layouts/MainLayout.vue';
import Content from '@core/layouts/Content.vue';
import TrackingByContinent from './Pages/ByContinent/Index'
export default {
    components: {
        MainLayout,
        Content,
        TrackingByContinent
    },
};
</script>

<style lang="scss" scoped></style>
