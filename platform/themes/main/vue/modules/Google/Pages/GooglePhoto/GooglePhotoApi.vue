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
                        <masonry :cols="{default: 5, 1000: 4, 700: 3, 400: 1}" :gutter="{default: '5px'}">
                            <div v-for="(item, index) in imgsArr" :key="index">
                                <a class="d-block mansory-image" data-fancybox="google-photo-images" :href="`${item.baseUrl}=w2048-h1024`">
                                    <img class="img-fluid" :src="_.get(item,'baseUrl')" alt="Image">
                                </a>
                            </div>
                        </masonry>
                    </a-col>
                    <a-col :span="24" style="text-align: center">
                        <video controls>
                            <source src="https://lh3.googleusercontent.com/lr/AFBm1_ZYBpBQw3W1-gVghDYUWknPtHR9D03f1g7LwFFwBfsqY8M_9ScHo_R_zF2DRCzREvJFGMz74AvaWbeMg-DjwyHAdm6uccbIBReOQL_lRjh54cb3tB0Tkh8GNDae4yVoMkHZ_fagMYY_QXfZz4iPXIkzkDbx3XU6okunTUG6bvNNz8Xmmly3Eq6_-jZAYAtcWpSnbdp_TrnPcRrXoHsD2dDPzCvO_Z_bN-mPmNMVVnpjLQFaJPE54u8wDX6yh90K2ciMbCatwRqoHJMwDnSlr8kBBFnEhr9t6o5JwsTb0H-6KPNxO0_wtYy34iSeQf28ZYyrx9ZG3EpGE3WUZZaxW-wFb1fK00SJvr6d4CPlRPlp5Y6W9SfQv7J6vGYGmtAELk3ixNuohEa9ANYM_YM7gqR0UBDNHtrddt-zR0HPBUh-q0k3w8SkePAOV0nSv0CDkkVnHAwW1dIMZBxvK4UVctVwBHpotdnDHwTLt3pMO9sXsv4h0lOHNz71_VK72d0jjWWSVkIPn8ulpS1nlkl1hG1fG5M_lCck_xtcsBlx3Uw8VniM_LTa44z2tIXEkP96kvS1M5gAyYGMbMqON_uusiFbQMHEwgrpif_duZtlP7tsn_bwLb2MAyLuufa-9oCVr18HZAv8E0EfvdomqUY83xH3Z0kWs-5rk5DMsIkPJQcZVeSxPupM8nPhel2PmfdT1r8zEBKpu9gWd8jUJ6mWhzNo9r6FmENqlR-_5nBsLeKIvJmUcR0nX0hgGqjDnhyvh8iICbWWEtdWK0TFc4IM8HGLFx5-DiOid0-n1hxa6xpZ0bYzBNpjJRtOIiuH0-bPwx34TrZ1Inuhclo-zQM"/>
                        </video>
                        <el-button :native-type="'button'" type="primary" icon="el-icon-plus" @click="getMoreMedia" :loading="moreLoading">Show more</el-button>
                    </a-col>
                </a-row>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue'
import {LoaderPlugin} from 'vue-google-login';
import {mapActions, mapMutations} from 'vuex'
import VueMasonry from 'vue-masonry-css'

Vue.use(VueMasonry);

Vue.use(LoaderPlugin, {
    client_id: "736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com"
});

export default {
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
        });
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
                        // const appendImgs = mediaItems.map(function (o) {
                        //     return o.baseUrl;
                        // });
                        this.imgsArr = [...imgsArr, ...mediaItems]
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
