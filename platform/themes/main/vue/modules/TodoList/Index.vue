<template>
    <main-layout>
        <Content>
            <template v-slot:content>
                <div class="right-content">
                    <div class="wrap">
                        <div class="wrap_title">
                            <h1 class="wrap_title-text">Task Management</h1>
                            <span class="wrap_title-count">Total (15)</span>
                        </div>
                        <Toolbar></Toolbar>
                        <Table></Table>
                    </div>
                </div>
            </template>
        </Content>
    </main-layout>
</template>

<script>
import MainLayout from '@core/layouts/MainLayout.vue';
import Content from '@core/layouts/Content.vue';
import Toolbar from './Components/Toolbar';
import Table from './Components/Table';
import {AgGridVue} from 'ag-grid-vue';

export default {
    components: {
        MainLayout,
        Content,
        AgGridVue,
        Toolbar,
        Table
    },
};
</script>

<style lang="scss" scoped></style>
