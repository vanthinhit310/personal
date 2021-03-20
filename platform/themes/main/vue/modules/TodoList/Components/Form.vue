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
                        <div class="form__group-label required"><span>Deadline</span></div>
                        <div class="form__group-input">
                            <ValidationProvider name="Deadline" rules="required" v-slot="{errors}">
                                <el-date-picker class="w-100" :format="`dd/MM/yyyy HH:mm`" :editable="false" v-model="formData.deadline" type="datetime" placeholder="Deadline"> </el-date-picker>
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
export default {
    components: {
        EditorField,
    },
    data() {
        return {
            loading: false,
            formData: {
                name: '',
                description: '',
                deadline : ''
            },
        };
    },
    props: ['visible'],
    methods: {
        handleCreate(e) {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
                this.onClose();
            }, 3000);
        },
        onClose(e) {
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
