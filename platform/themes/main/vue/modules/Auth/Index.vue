<template>
    <single-layout>
        <div class="login-wrapper">
            <ValidationObserver ref="form">
                <form @submit.prevent="handleLogin">
                    <div class="form login__form">
                        <div class="form__title">Login</div>
                        <div class="form__group">
                            <a-row type="flex" justify="center" align="middle">
                                <a-col :span="12" style="text-align: center">
                                    <el-button :native-type="'button'" @click="handleClickGoogleSignIn" round>Login with Google</el-button>
                                </a-col>
                                <a-col :span="12" style="text-align: center">
                                    <el-button :native-type="'button'" round>Login with Facebook</el-button>
                                </a-col>
                            </a-row>
                        </div>
                        <div class="form__group">
                            <div class="form__group-label required">
                                <span>Email</span>
                            </div>
                            <div class="form__group-input">
                                <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }">
                                    <el-input placeholder="Email" v-model="formData.email"></el-input>
                                    <span class="error-message" v-show="errors[0]">{{ errors[0] }}</span>
                                </ValidationProvider>
                            </div>
                        </div>
                        <div class="form__group">
                            <div class="form__group-label required">
                                <span>Password</span>
                            </div>
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
import {mapActions, mapMutations} from 'vuex';
import SingleLayout from '@core/layouts/SingleLayout';

import Vue from 'vue'
import GAuth from 'vue-google-oauth2'
const gauthOption = {
    clientId: '736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com',
    scope: 'profile email',
    prompt: 'consent'
}
Vue.use(GAuth, gauthOption)

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
        ...mapActions('auth', ['login', 'me', 'googleLogin']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        async handleClickGoogleSignIn() {
            try {
                const googleUser = await this.$gAuth.signIn();
                if (!googleUser) {
                    return null;
                }
                const formData = new FormData();
                const profile = this.$gAuth.GoogleAuth.currentUser.get().getBasicProfile()

                formData.append('first_name', profile.getFamilyName())
                formData.append('last_name', profile.getGivenName())
                formData.append('email', profile.getEmail())
                formData.append('avatar', profile.getImageUrl())


                await this.googleLogin(formData);
                console.log('ID: ' + profile.getId());
                console.log('Full Name: ' + profile.getName());
                console.log('Given Name: ' + profile.getGivenName());
                console.log('Family Name: ' + profile.getFamilyName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail());
            } catch (error) {
                //on fail do something
                console.error(error);
                return null;
            }
        },
        async handleLogin() {
            this.$refs.form.validate().then(async (validated) => {
                if (!validated) return false;
                try {
                    this.setLoadingState(true);
                    this.loading = true;
                    const response = await this.login(this.formData);
                    const {error} = response.data;
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
            this.formData = {email: 'trump@demo.com', password: ''};
            const {redirect} = this.$route.query;
            this.$router.push({path: !redirect ? '/' : redirect});
        },
    },
};
</script>

<style lang="scss" scoped></style>
