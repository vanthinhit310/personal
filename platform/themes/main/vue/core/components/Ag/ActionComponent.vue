<template>
    <div class="table__action">
        <ul class="__action">
            <li class="__action_item" @click="handeClickEdit">
                <el-tooltip class="item" effect="dark" content="Edit" placement="top">
                    <el-button type="primary" icon="el-icon-edit-outline"></el-button>
                </el-tooltip>
            </li>
            <li class="__action_item" @click="handleClickRemove">
                <el-tooltip class="item" effect="dark" content="Destroy" placement="top">
                    <el-button type="danger" icon="el-icon-delete"></el-button>
                </el-tooltip>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: ['value'],
    data() {
        return {};
    },
    methods: {
        handleClickRemove(e) {
            this.$emit('removeResource', e);
        },
        handeClickEdit() {
            this.$emit('editResource');
        },
    },
};
</script>

<style lang="scss" scoped></style>
