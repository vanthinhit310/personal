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
                                    <GoogleLogin type="button" class="el-button el-button--default el-button--medium is-round" :params="params" :onSuccess="onGoogleLoginSuccess" :onFailure="onGoogleLoginFailure">Login with Google</GoogleLogin>
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
import GoogleLogin from 'vue-google-login';

export default {
    components: {
        SingleLayout,
        GoogleLogin
    },
    data() {
        return {
            loading: false,
            formData: {
                email: 'trump@demo.com',
                password: '',
            },
            params: {
                client_id: "736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com"
            },
        };
    },

    methods: {
        ...mapActions('auth', ['login', 'me', 'googleLogin']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        async onGoogleLoginSuccess(googleUser) {
            try {
                const formData = new FormData();
                const profile = googleUser.getBasicProfile()
                formData.append('first_name', profile.getFamilyName())
                formData.append('last_name', profile.getGivenName())
                formData.append('email', profile.getEmail())
                formData.append('avatar', profile.getImageUrl())
                this.setLoadingState(true);
                const response = await this.googleLogin(formData);
                const {error} = response.data;
                if (!error) {
                    await this.me();
                    this.handleAfterLogin();
                }
            } catch (e) {
                console.log(e.message)
            }
            this.setLoadingState(false);
        },
        async onGoogleLoginFailure(error) {
            console.log(error);
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

<style lang="scss" scoped>
.google-btn {
    width: 184px;
    height: 42px;
    background-color: #4285f4;
    border-radius: 2px;
    box-shadow: 0 3px 4px 0 rgba(0, 0, 0, .25);

    .google-icon-wrapper {
        position: absolute;
        margin-top: 1px;
        margin-left: 1px;
        width: 40px;
        height: 40px;
        border-radius: 2px;
        background-color: #fff;
    }

    .google-icon {
        position: absolute;
        margin-top: 11px;
        margin-left: 11px;
        width: 18px;
        height: 18px;
    }

    .btn-text {
        float: right;
        margin: 11px 11px 0 0;
        color: #fff;
        font-size: 14px;
        letter-spacing: 0.2px;
    }

    &:hover {
        box-shadow: 0 0 6px #4285f4;
    }

    &:active {
        background: #1669F2;
    }
}
</style>
