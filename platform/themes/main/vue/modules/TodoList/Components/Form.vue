<template>
    <a-modal :zIndex="5" class="task-modal" :footer="null" :visible="visible" title="Create new task" @ok="handleCreate" @cancel="onClose">
        <ValidationObserver ref="taskForm" v-slot="{invalid}">
            <form @submit.prevent="handleCreate">
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
                                <el-select auto-complete="on" :clearable="true" class="w-100" v-model="formData.assignTo" filterable remote reserve-keyword placeholder="Assign to" :remote-method="serchUser" :loading="fetchMemberLoading">
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
                    <div class="form__action">
                        <el-button @click.native="onClose" native-type="button" icon="el-icon-circle-close">Cancle</el-button>
                        <el-button :loading="loading" type="success" :disabled="invalid" icon="el-icon-circle-check" native-type="submit" @click="handleCreate">Save</el-button>
                    </div>
                </div>
            </form>
        </ValidationObserver>
    </a-modal>
</template>

<script>
import EditorField from '@core/components/EditorField';
import {mapActions, mapGetters} from 'vuex';
export default {
    components: {
        EditorField,
    },
    data() {
        return {
            loading: false,
            fetchMemberLoading: false,
            memberOption: [],
            formData: {
                name: '',
                description: '',
                deadline: '',
                assignTo: '',
            },
        };
    },
    props: ['visible'],
    methods: {
        ...mapActions('todoList', ['fetchMembers', 'create']),
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
        async handleCreate() {
            this.$refs.taskForm.validate().then(async (validated) => {
                if (!validated) return false;

                try {
                    this.loading = true;
                    await this.create(this.formData);
                    this.onClose();
                } catch (err) {
                    console.log(`err`, err);
                }
                this.loading = false;
            });
        },
        resetForm() {
            this.formData = {
                ...this.formData,
                name: '',
                description: '',
                deadline: '',
                assignTo: '',
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
};
</script>

<style>
.ck-editor .ck-editor__main .ck-content {
    min-height: 150px;
}
</style>
