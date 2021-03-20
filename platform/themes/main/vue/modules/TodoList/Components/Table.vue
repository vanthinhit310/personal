<template>
    <div class="wrap_table">
        <ag-grid-vue
            id="myTable"
            class="ag-theme-alpine"
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
            :headerHeight="40"
            :sideBar="true"
            :rowData="rowData"
            :loadingOverlayComponent="loadingOverlayComponent"
            :frameworkComponents="frameworkComponents"
            style="width: 100%; height: 100%"
        ></ag-grid-vue>
    </div>
</template>

<script>
import {AgGridVue} from 'ag-grid-vue';
import {mapGetters, mapActions} from 'vuex';
import Action from '@core/components/Ag/Action.js';
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
    beforeMount() {
        this.columnDefs = [
            {headerName: 'No', field: 'id', maxWidth: 60, sortable: false, resizable: false, filter: false},
            {headerName: 'Title', field: 'name'},
            {
                headerName: 'Author',
                field: 'author',
                valueGetter: function (params) {
                    return _.get(params, 'data.author.fullname', '');
                },
            },
            {
                headerName: 'Assign to',
                field: 'assignedTo',
                valueGetter: function (params) {
                    return _.get(params, 'data.assignedTo.fullname', '');
                },
            },
            {
                headerName: 'Deadline',
                field: 'deadline',
            },
            {
                headerName: 'Piority',
                field: 'piority',
            },
            {
                headerName: 'Status',
                field: 'status',
            },
            {
                field: 'Action',
                maxWidth: 160,
                cellRenderer: 'action',
                pinned: 'right',
                filter: false,
                sortable: false,
            },
        ];
        this.context = {componentParent: this};
        this.frameworkComponents = {
            action: Action,
        };
    },
    computed: {
        ...mapGetters({
            resources: 'todoList/getResources',
        }),
    },
    mounted() {
        this.gridApi = this.gridOptions.api;
        this.gridColumnApi = this.gridOptions.columnApi;
    },
    methods: {
        ...mapActions('todoList', ['destroy']),
        async onGridReady() {
            this.gridApi.sizeColumnsToFit();
        },
        async contextParentMethod(cell) {
            const {data, rowIndex, type} = cell;
            switch (type) {
                case 'destroy':
                    await this.destroy(_.get(data, 'id', ''));
                    break;

                case 'edit':
                    console.log(data);
                    break;
            }
        },
    },
    watch: {
        resources() {
            this.rowData = this.resources;
        },
    },
};
</script>

<style lang="scss" scoped></style>
