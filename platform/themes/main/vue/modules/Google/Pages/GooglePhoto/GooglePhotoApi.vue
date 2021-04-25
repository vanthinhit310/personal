<template>
    <div class="wrap">
        <div class="wrap_title">
            <h1 class="wrap_title-text">Google Photo API</h1>
            <div class="wrap_content">
                <a-row :gutter="[20,20]">
                    <a-col :span="24">
                        <el-button @click="handleAccessScopePhoto" round>Grant permission to access for your google photos</el-button>
                    </a-col>

                    <a-col :span="24">
                        <masonry
                            :cols="3"
                            :gutter="30"
                        >
                            <div v-for="(item, index) in imgsArr" :key="index">
                                <a class="d-block">
                                    <img class="img-fluid" :src="item" alt="Image">
                                </a>
                            </div>
                        </masonry>
                    </a-col>
                    <a-col :span="24" style="text-align: center">
                        <el-button :native-type="'button'" type="primary" icon="el-icon-plus" @click="getMoreMedia" :loading="moreLoading">Show more</el-button>
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
import {mapActions, mapMutations} from 'vuex'
import VueMasonryGallery from "vue-masonry-gallery";
import VueMasonry from 'vue-masonry-css'

Vue.use(VueMasonry);
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
    components: {
        VueMasonryGallery
    },
    data() {
        return {
            imgsArr: [],
            accessToken: '',
            pageToken: '',
            moreLoading: false
        };
    },
    mounted() {
        Vue.GoogleAuth.then(async (auth2) => {
            let self = this;
            if (auth2.isSignedIn.get()) {
                if (!auth2.currentUser.get().hasGrantedScopes('https://www.googleapis.com/auth/photoslibrary')) {
                    this.$alert('Please click to Grant permission to access for your google photos button for access permission to your google photos library', 'Title', {
                        confirmButtonText: 'OK',
                    });
                    /*await auth2.grantOfflineAccess({
                        scope: 'profile email https://www.googleapis.com/auth/photoslibrary'
                    });*/
                } else {
                    let authResponse = await auth2.currentUser.get().reloadAuthResponse();
                    let accessToken = _.get(authResponse, 'access_token', '');
                    self.accessToken = accessToken;
                    if (!!accessToken) {
                        await this.fetchMediaItems(accessToken);
                    }
                }
            }
        })
    },
    methods: {
        ...mapActions('google', ['getMediaItems']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        handleAccessScopePhoto() {
            var authResponse;
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
                const accessToken = _.get(authResponse, 'access_token')
                if (accessToken) {
                    await this.fetchMediaItems(accessToken);
                }
            })


        },
        async fetchMediaItems(accessToken, pageToken = null) {
            let self = this
            if (!!accessToken) {
                this.setLoadingState(true)
                try {
                    const {imgsArr} = self
                    const response = await this.getMediaItems({accessToken, pageToken});
                    const {mediaItems} = response.data
                    const {nextPageToken} = response.data
                    if (!!mediaItems) {
                        const appendImgs = mediaItems.map(function (o) {
                            return o.baseUrl;
                        });
                        this.imgsArr = [...imgsArr, ...appendImgs]
                    }

                    if (!!nextPageToken) {
                        self.pageToken = nextPageToken;
                    }
                } catch (e) {
                    console.log(e.message)
                }
                this.setLoadingState(false)
            }
        },
        async getMoreMedia() {
            try {
                this.moreLoading = true
                await this.fetchMediaItems(this.accessToken, this.pageToken)
                this.moreLoading = false
            } catch (e) {
                console.log(e.message)
            }
        }
    },
}
</script>

<style scoped>

</style>
