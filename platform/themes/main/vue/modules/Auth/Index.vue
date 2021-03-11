<template>
    <no-sidebar-layout>
        <div class="login-wrapper">
            <ValidationObserver ref="form">
                <form @submit.prevent="handleLogin">
                    <div class="form login__form">
                        <div class="form__title">Login</div>
                        <div class="form__group">
                            <div class="form__group-label required"><span>Email</span></div>
                            <div class="form__group-input">
                                <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                                    <a-input v-model="formData.email" size="large" placeholder="Email" />
                                    <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </div>
                        </div>
                        <div class="form__group">
                            <div class="form__group-label required"><span>Password</span></div>
                            <div class="form__group-input">
                                <ValidationProvider name="Password" rules="required" v-slot="{ errors }">
                                    <a-input-password v-model="formData.password" size="large" placeholder="Password" />
                                    <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </div>
                        </div>
                        <div class="form__hyperlink">
                            <router-link :to="{ name: 'login' }"><a-icon type="user-add" /> Register</router-link>
                            <router-link :to="{ name: 'login' }"><a-icon type="lock" /> Forgot password?</router-link>
                        </div>
                        <div class="form__action">
                            <a-button :htmlType="'submit'" size="large" icon="login" :loading="loading" type="primary">Login</a-button>
                        </div>
                    </div>
                </form>
            </ValidationObserver>
        </div>
    </no-sidebar-layout>
</template>

<script>
import { mapActions, mapMutations } from 'vuex';
import NoSidebarLayout from '@core/layouts/NoSidebarLayout';
export default {
    components: {
        NoSidebarLayout,
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
