<template>
    <ckeditor :value="value" @input="onEditorInput" :editor-url="editorUrl" :config="editorConfig"></ckeditor>
</template>

<script>
import Vue from 'vue';
import CKEditor from 'ckeditor4-vue';

Vue.use(CKEditor);
export default {
    data() {
        return {
            editorUrl: '/js/packages/ckeditor/ckeditor.js',
            editorConfig: {
                removeButtons: 'NewPage,Print,Save,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Flash,Smiley,PageBreak,ShowBlocks,About,Language,Iframe,Image',
                fullPage: false,
                sourceAreaTabSize: 8,
                height : 80,
                allowedContent: false,
                autoGrow_onStartup: false,
                toolbarGroups: [
                    {name: 'document', groups: ['mode', 'document', 'doctools']},
                    {name: 'clipboard', groups: ['clipboard', 'undo']},
                    {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                    {name: 'forms', groups: ['forms']},
                    {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                    {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
                    {name: 'links', groups: ['links']},
                    {name: 'insert', groups: ['insert']},
                    {name: 'styles', groups: ['styles']},
                    {name: 'colors', groups: ['colors']},
                    {name: 'tools', groups: ['tools']},
                    {name: 'others', groups: ['others']},
                    {name: 'about', groups: ['about']},
                ],
            },
        };
    },
    props: ['value'],
    methods: {
        onEditorInput: function (value) {
            this.$emit('input', value);
        },
    },
};
</script>

<style lang="scss" scoped></style>
