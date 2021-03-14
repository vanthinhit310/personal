<template>
    <single-layout>
        <div class="login-wrapper">
            <ValidationObserver ref="form">
                <form @submit.prevent="handleLogin">
                    <div class="form login__form">
                        <div class="form__title">Login</div>
                        <div class="form__group">
                            <div class="form__group-label required"><span>Email</span></div>
                            <div class="form__group-input">
                                <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                                    <el-input placeholder="Email" v-model="formData.email"></el-input>
                                    <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </div>
                        </div>
                        <div class="form__group">
                            <div class="form__group-label required"><span>Password</span></div>
                            <div class="form__group-input">
                                <ValidationProvider name="Password" rules="required" v-slot="{ errors }">
                                    <el-input placeholder="Password" v-model="formData.password" show-password></el-input>
                                    <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </div>
                        </div>
                        <div class="form__hyperlink">
                            <router-link :to="{ name: 'login' }"><i class="el-icon-user"></i> Register</router-link>
                            <router-link :to="{ name: 'login' }"><i class="el-icon-unlock"></i> Forgot password?</router-link>
                        </div>
                        <div class="form__action">
                            <el-button type="primary" :loading="loading" native-type="submit" icon="el-icon-right">Login</el-button>
                        </div>
                    </div>
                </form>
            </ValidationObserver>
        </div>
    </single-layout>
</template>

<script>
import { mapActions, mapMutations } from 'vuex';
import SingleLayout from '@core/layouts/SingleLayout';
export default {
    components: {
        SingleLayout,
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
