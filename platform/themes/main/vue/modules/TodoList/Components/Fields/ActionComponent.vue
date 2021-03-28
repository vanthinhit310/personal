<template>
    <div class="table__action">
        <ul class="__action">
            <li class="__action_item">
                <el-button @click="handeClickEdit" circle :disabled="isAuthorOfResource" plain type="primary" icon="el-icon-edit-outline"></el-button>
            </li>
            <li class="__action_item">
                <el-button @click="handleClickRemove" :disabled="isAuthorOfResource" circle plain type="danger" icon="el-icon-delete"></el-button>
            </li>
        </ul>
    </div>
</template>

<script>
import {getters, mapGetters} from 'vuex';

export default {
    props: ['value'],
    data() {
        return {};
    },
    computed: {
        ...mapGetters({
            currentUser: 'auth/getCurrentUser',
        }),
        isAuthorOfResource() {
            const resourceAuthorId = _.get(this.value, 'author.id');
            const currentUserId = _.get(this.currentUser, 'id');
            if (currentUserId == resourceAuthorId) {
                return false;
            }
            return true;
        },
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
