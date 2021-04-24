<template>
    <div class="wrap">
        <div class="wrap_title">
            <h1 class="wrap_title-text">Google Photo API</h1>
            <div class="wrap_content">
                <a-row :gutter="[15,15]">
                    <a-col :span="24">
                        <el-button @click="handleClickSignIn" round>Grant permission to access for your google photos</el-button>
                    </a-col>
                </a-row>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import GAuth from 'vue-google-oauth2'
const gauthOption = {
    clientId: '736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com',
    scope: 'profile email https://www.googleapis.com/auth/photoslibrary',
    prompt: 'consent'
}
Vue.use(GAuth, gauthOption)

export default {
    data() {
        return {
            isInit: false,
            isSignIn: false,
            accessToken : ''
        };
    },
    methods: {
        async handleClickUpdateScope() {
            const option = new window.gapi.auth2.SigninOptionsBuilder();
            option.setScope("email https://www.googleapis.com/auth/drive.file");
            const googleUser = this.$gAuth.GoogleAuth.currentUser.get();
            try {
                await googleUser.grant(option);
                console.log("success");
            } catch (error) {
                console.error(error);
            }
        },
        handleClickLogin() {
            this.$gAuth
                .getAuthCode()
                .then((authCode) => {
                    //on success
                    console.log("authCode", authCode);
                })
                .catch((error) => {
                    //on fail do something
                });
        },
        async handleClickSignIn() {
            try {
                const googleUser = await this.$gAuth.signIn();
                if (!googleUser) {
                    return null;
                }
                console.log("getAuthResponse", googleUser.getAuthResponse());
                this.isSignIn = this.$gAuth.isAuthorized;
            } catch (error) {
                //on fail do something
                console.error(error);
                return null;
            }
        },
        async handleClickSignOut() {
            try {
                await this.$gAuth.signOut();
                this.isSignIn = this.$gAuth.isAuthorized;
                console.log("isSignIn", this.$gAuth.isAuthorized);
            } catch (error) {
                console.error(error);
            }
        },
        handleClickDisconnect() {
            window.location.href = `https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=${window.location.href}`;
        },
    },
    created() {
        let that = this;
        let checkGauthLoad = setInterval(function () {
            that.isInit = that.$gAuth.isInit;
            that.isSignIn = that.$gAuth.isAuthorized;
            if (that.isInit) clearInterval(checkGauthLoad);
        }, 1000);
    },
}
</script>

<style scoped>

</style>
