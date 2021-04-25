<template>
    <div class="wrap">
        <div class="wrap_title">
            <h1 class="wrap_title-text">Google Photo API</h1>
            <div class="wrap_content">
                <a-row :gutter="[15,15]">
                    <a-col :span="24">
                        <el-button @click="handleAccessScopePhoto" round>Grant permission to access for your google photos</el-button>
                    </a-col>
                </a-row>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import GAuth from 'vue-google-oauth2'
import {LoaderPlugin} from 'vue-google-login';

const gauthOption = {
    clientId: '736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com',
    scope: 'profile email https://www.googleapis.com/auth/photoslibrary',
    prompt: 'consent'
}
Vue.use(GAuth, gauthOption)
Vue.use(LoaderPlugin, {
    client_id: "736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com"
});
export default {
    data() {
        return {
            isSignIn: false,
            auth2: ''
        };
    },
    async mounted() {
        Vue.GoogleAuth.then(async (auth2) => {
            if (auth2.isSignedIn.get()) {
                await auth2.signOut();
            }
        })
    },
    methods: {
        async handleAccessScopePhoto() {
            let authResponse;
            Vue.GoogleAuth.then(async (auth2) => {
                if (auth2.isSignedIn.get()) {

                    await auth2.grantOfflineAccess({
                        scope: 'profile email https://www.googleapis.com/auth/photoslibrary'
                    });

                    authResponse = auth2.currentUser.get().getAuthResponse();
                } else {

                    await auth2.signIn({
                        scope: 'profile email https://www.googleapis.com/auth/photoslibrary'
                    });
                    
                    authResponse = auth2.currentUser.get().getAuthResponse();
                }
                console.log('====================================');
                console.log(authResponse);
                console.log(auth2.currentUser.get());
                console.log('====================================');
            })

        }
    },
}
</script>

<style scoped>

</style>
