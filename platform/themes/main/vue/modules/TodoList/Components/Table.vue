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
            :pagination="true"
            :rowHeight="rowHeight"
            :context="context"
            :headerHeight="40"
            :rowData="rowData"
            :loadingOverlayComponent="loadingOverlayComponent"
            @selection-changed="onSelectionChanged"
            :frameworkComponents="frameworkComponents"
            style="width: 100%; height: 100%"
        ></ag-grid-vue>
    </div>
</template>

<script>
import {AgGridVue} from 'ag-grid-vue';
import {mapGetters, mapActions, mapMutations} from 'vuex';
import Action from '@core/components/Ag/Action.js';
import BadgeField from './Badge';
import Status from './Status';
import Piority from './Piority';
export default {
    components: {
        AgGridVue,
        badge: BadgeField,
        status: Status,
        piority: Piority,
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
                minWidth: 150,
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
            {
                headerName: 'No',
                field: 'id',
                maxWidth: 90,
                sortable: false,
                resizable: false,
                filter: false,
                headerCheckboxSelection: true,
                headerCheckboxSelectionFilteredOnly: true,
                checkboxSelection: true,
            },
            {
                headerName: 'Title',
                field: 'name',
            },
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
                cellRendererFramework: 'badge',
            },
            {
                headerName: 'Deadline',
                field: 'deadline',
            },
            {
                headerName: 'Piority',
                field: 'piority',
                cellRendererFramework: 'piority',
            },
            {
                headerName: 'Status',
                field: 'status',
                cellRendererFramework: 'status',
            },
            {
                headerName: 'Action',
                headerClass: '__center',
                maxWidth: 160,
                cellRenderer: 'action',
                pinned: 'right',
                filter: false,
                sortable: false,
            },
        ];
        this.rowSelection = 'multiple';
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
        ...mapMutations({
            setResource: 'todoList/setResource',
        }),
        async onGridReady() {
            console.log('Ready!');
        },
        onSelectionChanged() {
            const selectedRows = this.gridApi.getSelectedRows();
            const idSelected = selectedRows.map((o) => {
                return o.id;
            });
            this.$emit('rowSelectedChange', idSelected);
        },
        async contextParentMethod(cell) {
            const {data, rowIndex, type} = cell;
            switch (type) {
                case 'destroy':
                    await this.destroy(_.get(data, 'id', ''));
                    break;

                case 'edit':
                    if (!!data) {
                        this.setResource(data);
                    }
                    break;
            }
        },
    },
    watch: {
        resources() {
            console.log(this.resources);
            this.rowData = this.resources;
        },
    },
};
</script>

<style lang="scss" scoped></style>
