<template>
    <div class="wrap_table">
        <a-modal v-model="visible" title="Enter your reason to missed dealine for task" on-ok="handleMissedDeadline">
            <template slot="footer">
                <a-button @click="handleCloseModal"> Close </a-button>
                <a-button @click="handleMissedDeadline" type="primary" :loading="missedDealineLoading"> Save </a-button>
            </template>
            <el-input placeholder="Enter your reason" v-model="missedDeadline"></el-input>
        </a-modal>
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
            @cellValueChanged="handleCellValueChanged"
            :context="context"
            :headerHeight="40"
            :rowData="rowData"
            :singleClickEdit="true"
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
import Action from './Fields/Action.js';
import BadgeField from './Fields/Badge';
import Status from './Fields/Status';
import Piority from './Fields/Piority';
export default {
    components: {
        AgGridVue,
        badge: BadgeField,
        status: Status,
        piority: Piority,
    },
    props: {
        columns: {
            type: Array,
            default: [],
        },
        isExport: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            gridOptions: {
                suppressCellSelection: true,
                undoRedoCellEditing: true,
                undoRedoCellEditingLimit: 20,
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
            /* missed deadline data */
            visible: false,
            missedDealineLoading: false,
            missedDeadline: '',
            cellValueChange: '',
        };
    },
    beforeMount() {
        let self = this;
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
                field: 'members',
                cellRendererFramework: 'badge',
                valueGetter: function (params) {
                    const memberName = _.get(params, 'data.members', []).map((o) => {
                        return o.fullname;
                    });
                    return _.join(memberName, ',');
                },
            },
            {
                headerName: 'Deadline',
                field: 'deadline',
            },
            {
                headerName: 'Piority',
                field: 'piority',
                cellRendererFramework: 'piority',
                cellEditor: 'agSelectCellEditor',
                cellEditorParams: {
                    values: ['LOW', 'NORMAL', 'HIGH'],
                },
                editable: function (params) {
                    const currentUserId = _.get(self.currentUser, 'id');
                    if (currentUserId == _.get(params, 'data.author.id')) {
                        return true;
                    }
                    return false;
                },
            },
            {
                headerName: 'Status',
                field: 'status',
                cellRendererFramework: 'status',
                cellEditor: 'agSelectCellEditor',
                cellEditorParams: {
                    values: ['NEW', 'IN PROGRESS', 'COMPLETED', 'MISSED DEADLINE'],
                },
                editable: function (params) {
                    const currentUserId = _.get(self.currentUser, 'id');
                    const index = _.findIndex(_.get(params, 'data.members', []), (o) => {
                        return o.id == currentUserId;
                    });
                    const status = _.get(params, 'data.status');
                    if ((currentUserId == _.get(params, 'data.author.id') || index != -1) && status != 'MISSED DEADLINE' && status != 'MISSED DEADLINE') {
                        return true;
                    }
                    return false;
                },
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
        this.rowHeight = 50;
        this.context = {componentParent: this};
        this.frameworkComponents = {
            action: Action,
        };
    },
    computed: {
        ...mapGetters({
            resources: 'todoList/getResources',
            currentUser: 'auth/getCurrentUser',
        }),
    },
    mounted() {
        this.gridApi = this.gridOptions.api;
        this.gridColumnApi = this.gridOptions.columnApi;
    },
    methods: {
        ...mapActions('todoList', ['destroy', 'setColumns', 'quickUpdate']),
        ...mapMutations({
            setResource: 'todoList/setResource',
            setLoadingState: 'dashboard/setLoadingState',
        }),
        async onGridReady() {
            try {
                let self = this;
                const columns = await self.gridColumnApi.getColumnState();
                if (!!columns) {
                    const array_columns = columns.map((o) => {
                        return {
                            name: _.get(self.gridColumnApi.getColumn(o.colId), 'colDef.headerName', ''),
                            id: o.colId,
                            visible: 1,
                        };
                    });
                    if (!!array_columns) {
                        await this.setColumns(array_columns);
                    }
                }
            } catch (err) {}
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
                    this.setLoadingState(true);
                    await this.destroy(_.get(data, 'id', ''));
                    this.setLoadingState(false);
                    break;

                case 'edit':
                    if (!!data) {
                        this.setLoadingState(true);
                        await this.setResource(data);
                        this.setLoadingState(false);
                    }
                    break;
            }
        },
        async handleCellValueChanged(params) {
            try {
                const colId = _.get(params, 'column.colId');
                const newValue = _.get(params, 'newValue');
                const {data} = params;
                if (!!colId && !!newValue && !!data) {
                    switch (colId) {
                        case 'piority':
                            this.setLoadingState(true);
                            await this.quickUpdate({
                                id: _.get(data, 'id'),
                                param: {piority: newValue},
                            });
                            this.setLoadingState(false);
                            break;

                        case 'status':
                            if (newValue == 'MISSED DEADLINE') {
                                this.visible = true;
                                this.cellValueChange = params;
                            } else {
                                this.setLoadingState(true);
                                await this.quickUpdate({
                                    id: _.get(data, 'id'),
                                    param: {status: newValue},
                                });
                                this.setLoadingState(false);
                            }
                            break;
                    }
                }
            } catch (err) {}
        },
        async handleMissedDeadline(e) {
            this.setLoadingState(true);
            this.missedDealineLoading = true;
            const id = _.get(this.cellValueChange, 'data.id');
            const status = _.get(this.cellValueChange, 'newValue');
            try {
                await this.quickUpdate({
                    id: id,
                    param: {status: status, reason_missed_deadline: this.missedDeadline},
                });
                this.visible = false;
                this.missedDeadline = '';
                this.cellValueChange = '';
            } catch (err) {
                console.table(err);
            }
            this.missedDealineLoading = false;
            this.setLoadingState(false);
        },
        async handleCloseModal(e) {
            await this.undoCellEditing();
            this.visible = false;
            this.missedDeadline = '';
            this.cellValueChange = '';
        },
        async undoCellEditing() {
            await this.gridApi.undoCellEditing();
        },
    },
    watch: {
        resources() {
            this.rowData = this.resources;
        },
        columns: {
            handler() {
                let self = this;
                const {columns} = self;
                columns.forEach((o) => {
                    if (o.visible == 0) {
                        self.gridColumnApi.setColumnVisible(o.id, false);
                    } else {
                        self.gridColumnApi.setColumnVisible(o.id, true);
                    }
                });
            },
            deep: true,
        },
        isExport() {
            if (this.isExport) {
                this.gridApi.exportDataAsCsv();
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
