<template>
    <div class="table__action">
        <ul class="__action">
            <li class="__action_item" @click="handeClickEdit">
                <el-button circle plain type="primary" icon="el-icon-edit-outline"></el-button>
            </li>
            <li class="__action_item" @click="handleClickRemove">
                <el-button circle plain type="danger" icon="el-icon-delete"></el-button>
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
