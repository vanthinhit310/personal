<template>
    <has-sidebar-layout>
        <Content>
            <template v-slot:content>
                <h1>Tin nhắn</h1>
            </template>
        </Content>
    </has-sidebar-layout>
</template>

<script>
import { mapActions, mapMutations } from 'vuex';
import HasSidebarLayout from '@core/layouts/HasSidebarLayout.vue';
import Content from '@core/layouts/Content.vue';
export default {
    components: {
        HasSidebarLayout,
        Content
    },
    data() {
        return {
            loading: false,
            formData: {
                email: 'trump@demo.com',
                password: '',
            },
        };
    },
    methods: {
        ...mapActions('auth', ['login', 'me']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        async handleLogin() {
            this.$refs.form.validate().then(async (validated) => {
                if (!validated) return false;
                try {
                    this.setLoadingState(true);
                    this.loading = true;
                    const response = await this.login(this.formData);
                    const { error } = response.data;
                    if (!error) {
                        await this.me();
                        this.handleAfterLogin();
                    }
                } catch (err) {
                    console.log(err);
                }
                this.loading = false;
                this.setLoadingState(false);
            });
        },
        handleAfterLogin() {
            this.formData = { email: 'trump@demo.com', password: '' };
            const { redirect } = this.$route.query;
            this.$router.push({ path: !redirect ? '/' : redirect });
        },
    },
};
</script>

<style lang="scss" scoped></style>
