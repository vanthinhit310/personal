<template>
    <div class="table">
        <ag-grid-vue
            id="myTable"
            :gridOptions="gridOptions"
            @grid-ready="onGridReady"
            :columnDefs="columnDefs"
            :autoGroupColumnDef="autoGroupColumnDef"
            :defaultColDef="defaultColDef"
            :suppressRowClickSelection="true"
            :groupSelectsChildren="true"
            :rowSelection="rowSelection"
            :animateRows="true"
            :enableRangeSelection="true"
            :debounceVerticalScrollbar="true"
            :pagination="true"
            :rowHeight="rowHeight"
            :context="context"
            :headerHeight="35"
            :rowData="rowData"
            :loadingOverlayComponent="loadingOverlayComponent"
            :frameworkComponents="frameworkComponents"
        ></ag-grid-vue>
    </div>
</template>

<script>
import {AgGridVue} from 'ag-grid-vue';

export default {
    components: {
        AgGridVue,
    },
    data() {
        return {
            gridOptions: {
                suppressCellSelection: true,
            },
            gridApi: null,
            columnApi: null,
            columnDefs: null,
            autoGroupColumnDef: null,
            loadingOverlayComponent: null,
            context: null,
            defaultColDef: {
                flex: 1,
                wrapText: true,
                autoHeight: true,
                sortable: true,
                resizable: true,
                filter: true,
            },
            rowSelection: null,
            rowHeight: null,
            rowData: [],
            frameworkComponents: null,
        };
    },
    beforeMount(){

    },
    methods: {},
};
</script>

<style lang="scss" scoped></style>
