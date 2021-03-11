<template>
    <no-sidebar-layout>
        <div class="login-wrapper">
            <div class="form login__form">
                <div class="form__title">Login</div>
                <div class="form__group">
                    <div class="form__group-label required"><span>Email</span></div>
                    <div class="form__group-input">
                        <a-input size="large" placeholder="Email" />
                    </div>
                </div>
                <div class="form__group">
                    <div class="form__group-label required"><span>Password</span></div>
                    <div class="form__group-input">
                        <a-input-password size="large" placeholder="Password" />
                    </div>
                </div>
                <div class="form__hyperlink">
                    <router-link :to="{ name: 'login' }"><a-icon type="user-add" /> Register</router-link>
                    <router-link :to="{ name: 'login' }"><a-icon type="lock" /> Forgot password?</router-link>
                </div>
                <div class="form__action">
                    <a-button size="large" icon="login" :loading="loading" type="primary">Login</a-button>
                </div>
            </div>
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
        };
    },
};
</script>

<style lang="scss" scoped></style>
