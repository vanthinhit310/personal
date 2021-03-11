<template>
    <no-sidebar-layout>
        <div class="login-wrapper">
            <ValidationObserver v-slot="{ handleSubmit }">
                <form @submit.prevent="handleSubmit(handleLogin)">
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
import NoSidebarLayout from '@core/layouts/NoSidebarLayout';
export default {
    components: {
        NoSidebarLayout,
    },
    data() {
        return {
            loading: false,
            formData:{
                email : '',
                password : ''
            }
        };
    },
    methods: {
        handleLogin() {
            this.loading = true;
            setTimeout(() => {
                this.loading = false;
            }, 3000);
        },
    },
};
</script>

<style lang="scss" scoped></style>
