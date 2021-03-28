<template>
    <a-modal :zIndex="5" class="task-modal" :footer="null" :visible="visible" :title="isUpdate ? `Update task ${_.get(resource, 'name', '')}` : `Create new task`" @ok="handleSubmit" @cancel="onClose">
        <ValidationObserver ref="taskForm" v-slot="{invalid}">
            <form @submit.prevent="handleSubmit">
                <div class="form form-in-modal">
                    <div class="form__group">
                        <div class="form__group-label required"><span>Title</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Name" rules="required|max:250" v-slot="{errors}">
                                <el-input placeholder="Title" v-model="formData.name"></el-input>
                                <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-label required"><span>Description</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Description" rules="required" v-slot="{errors}">
                                <editor-field v-model="formData.description"></editor-field>
                                <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-label required"><span>Assign to</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Assign" rules="required" v-slot="{errors}">
                                <el-select class="w-100" collapse-tags :multiple="true" filterable remote reserve-keyword v-model="formData.members" placeholder="Assign to" :remote-method="serchUser" :loading="fetchMemberLoading">
                                    <el-option v-for="item in memberOption" :key="item.id" :label="_.get(item, 'fullname', '')" :value="item.id"> </el-option>
                                </el-select>
                                <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-label required"><span>Deadline</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Deadline" rules="required" v-slot="{errors}">
                                <el-date-picker class="w-100" :value-format="`dd/MM/yyyy HH:mm`" :format="`dd/MM/yyyy HH:mm`" :editable="false" v-model="formData.deadline" type="datetime" placeholder="Deadline"> </el-date-picker>
                                <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-label required"><span>Status</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Status" rules="required" v-slot="{errors}">
                                <el-select v-model="formData.status" placeholder="Select">
                                    <el-option v-for="(item, index) in statusOption" :key="index" :label="item" :value="item"> </el-option>
                                </el-select>
                                <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-label required"><span>Piority</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Piority" rules="required" v-slot="{errors}">
                                <el-select v-model="formData.piority" placeholder="Select">
                                    <el-option v-for="(item, index) in piorityOption" :key="index" :label="item" :value="item"> </el-option>
                                </el-select>
                                <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="form__action">
                        <el-button @click.native="onClose" native-type="button" icon="el-icon-circle-close">Cancle</el-button>
                        <el-button :loading="loading" type="success" :disabled="invalid" icon="el-icon-circle-check" native-type="submit" @click="handleSubmit">{{ isUpdate ? 'Update' : 'Save' }}</el-button>
                    </div>
                </div>
            </form>
        </ValidationObserver>
    </a-modal>
</template>

<script>
import EditorField from '@core/components/EditorField';
import {mapActions, mapGetters, mapMutations} from 'vuex';
export default {
    components: {
        EditorField,
    },
    data() {
        return {
            loading: false,
            processing: false,
            fetchMemberLoading: false,
            memberOption: [],
            statusOption: ['NEW', 'COMPLETED', 'IN PROGRESS', 'MISSED DEADLINE'],
            piorityOption: ['LOW', 'NORMAL', 'HIGH'],
            formData: {
                name: '',
                description: '',
                deadline: '',
                members: [],
                piority: 'NORMAL',
                status: 'NEW',
            },
        };
    },
    props: ['visible', 'isUpdate'],
    computed: {
        ...mapGetters({
            resource: 'todoList/getResource',
        }),
    },
    methods: {
        ...mapActions('todoList', ['fetchMembers', 'create', 'update']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        async serchUser(query) {
            try {
                if (query !== '') {
                    this.fetchMemberLoading = true;
                    const response = await this.fetchMembers({query: query, limit: 5});
                    const resources = _.get(response, 'data.resources', []);
                    if (!!resources) {
                        this.memberOption = resources;
                    }
                } else {
                    this.memberOption = [];
                }
            } catch (err) {
                console.log(`err`, err);
            }
            this.fetchMemberLoading = false;
        },
        async handleSubmit() {
            this.$refs.taskForm.validate().then(async (validated) => {
                if (!validated) return false;

                try {
                    this.setLoadingState(true);
                    this.loading = true;
                    if (this.isUpdate) {
                        await this.update({
                            id: _.get(this.resource, 'id', 0),
                            param: this.formData,
                        });
                    } else {
                        await this.create(this.formData);
                    }
                    this.onClose();
                } catch (err) {
                    console.log(`err`, err);
                }
                this.loading = false;
                this.setLoadingState(false);
            });
        },
        resetForm() {
            this.memberOption = [];
            this.formData = {
                ...this.formData,
                name: '',
                description: '',
                deadline: '',
                members: [],
            };
            this.$nextTick(() => {
                this.$refs.taskForm.reset();
            });
        },
        onClose(e) {
            this.resetForm();
            this.$emit('closeForm');
        },
    },
    watch: {
        async isUpdate() {
            this.processing = true;
            if (this.isUpdate) {
                try {
                    this.memberOption = _.get(this.resource, 'members', []);
                    this.formData = {
                        ...this.formData,
                        name: _.get(this.resource, 'name', ''),
                        description: _.get(this.resource, 'description', ''),
                        deadline: _.get(this.resource, 'deadline', ''),
                        members: _.get(this.resource, 'members', []).map((o) => {
                            return o.id;
                        }),
                        status: _.get(this.resource, 'status', 'NEW'),
                        piority: _.get(this.resource, 'piority', 'NORMAL'),
                    };
                } catch (err) {
                    console.log(`err`, err);
                }
            }
            this.processing = false;
        },
    },
};
</script>

<style scope></style>
