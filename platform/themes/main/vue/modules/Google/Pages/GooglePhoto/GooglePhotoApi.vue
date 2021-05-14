<template>
    <div class="wrap">
        <div class="wrap_title">
            <h1 class="wrap_title-text">Google Photo API</h1>
            <div class="wrap_content">
                <a-row :gutter="[20, 20]">
                    <a-col :span="24">
                        <a-row>
                            <a-col :span="3">
                                <el-button size="large" icon="el-icon-key" @click="handleAccessScopePhoto" round>Grant permission</el-button>
                            </a-col>
                        </a-row>
                    </a-col>

                    <a-col :span="24">
                        <masonry :cols="{default: 5, 1000: 4, 700: 3, 400: 1}" :gutter="{default: '5px'}">
                            <a v-for="(item, index) in mediaItems" :key="index" class="d-block mansory-image" data-fancybox="google-photo-images" :href="`${item.baseUrl}=w2048-h1024`">
                                <figure class="hover-rotate">
                                    <img class="img-fluid" :src="_.get(item, 'baseUrl')" alt="Image" />
                                </figure>
                            </a>
                        </masonry>
                    </a-col>
                     <a-col v-show="this.mediaItems.length > 0" :span="24" style="text-align: center">
                        <el-button :native-type="'button'" type="primary" icon="el-icon-plus" @click="getMoreMedia" :loading="moreLoading">Show more</el-button>
                    </a-col>
                </a-row>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';
import {LoaderPlugin} from 'vue-google-login';
import {mapActions, mapMutations} from 'vuex';
import VueMasonry from 'vue-masonry-css';

Vue.use(VueMasonry);

Vue.use(LoaderPlugin, {
    client_id: '736218758525-aag0djin4ktbvi66cvuiljggj33sn8ke.apps.googleusercontent.com',
});

export default {
    data() {
        return {
            imgsArr: [],
            accessToken: '',
            bearerToken: '',
            pageToken: '',
            moreLoading: false,
            filterParams: '',
            pickerOptions: {
                shortcuts: [
                    {
                        text: 'Last week',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                    {
                        text: 'Last month',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                    {
                        text: 'Last 3 months',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                    {
                        text: 'Last 6 months',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 180);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                    {
                        text: 'Last 9 months',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 270);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                    {
                        text: 'Last year',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 365);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                    {
                        text: 'Last 2 year',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 730);
                            picker.$emit('pick', [start, end]);
                        },
                    },
                ],
            },
        };
    },
    computed: {
        mediaItems() {
            return this.imgsArr.filter((o) => {
                return _.get(o, 'mimeType', '') != 'video/mp4';
            });
        },
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
                    let id_token = _.get(authResponse, 'id_token', '');
                    self.accessToken = accessToken;
                    self.bearerToken = id_token;
                    if (!!accessToken) {
                        await this.fetchMediaItems(accessToken, this.pageToken);
                    }
                }
            }
        });
    },
    methods: {
        ...mapActions('google', ['getMediaItems', 'filterMediaItems']),
        ...mapMutations({
            setLoadingState: 'dashboard/setLoadingState',
        }),
        handleAccessScopePhoto() {
            var authResponse;
            Vue.GoogleAuth.then(async (auth2) => {
                if (auth2.isSignedIn.get()) {
                    await auth2.grantOfflineAccess({
                        scope: 'profile email https://www.googleapis.com/auth/photoslibrary',
                    });
                    authResponse = auth2.currentUser.get().getAuthResponse();
                } else {
                    await auth2.signIn({
                        scope: 'profile email https://www.googleapis.com/auth/photoslibrary',
                    });
                    authResponse = auth2.currentUser.get().getAuthResponse();
                }
                const accessToken = _.get(authResponse, 'access_token');
                if (accessToken) {
                    await this.fetchMediaItems(accessToken);
                }
            });
        },
        async fetchMediaItems(accessToken, pageToken = null) {
            let self = this;
            if (!!accessToken) {
                this.setLoadingState(true);
                try {
                    const {imgsArr} = self;
                    const response = await this.getMediaItems({accessToken, pageToken});
                    const {mediaItems} = response.data;
                    const {nextPageToken} = response.data;
                    if (!!mediaItems) {
                        this.imgsArr = [...imgsArr, ...mediaItems];
                    }

                    if (!!nextPageToken) {
                        self.pageToken = nextPageToken;
                    }
                } catch (e) {
                    console.log(e.message);
                }
                this.setLoadingState(false);
            }
        },
        async getMoreMedia() {
            try {
                this.moreLoading = true;
                await this.fetchMediaItems(this.accessToken, this.pageToken);
                this.moreLoading = false;
            } catch (e) {
                console.log(e.message);
            }
        },
    },
};
</script>

<style scoped></style>
