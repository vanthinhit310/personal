<template>
    <has-sidebar-layout>
        <Content>
            <template v-slot:content>
                <div class="message-wrapper h100">
                    <div class="message__box">
                        <div class="message__box__left">
                            <div class="user__list">
                                <div v-for="i in 5" :key="i" class="user__item">
                                    <div class="user__item-avatar">
                                        <img src="https://picsum.photos/200/300" alt="User" />
                                    </div>
                                    <div class="user__item-lasted-message">
                                        <div class="user__name">Donal Trump</div>
                                        <div class="lasted__message">Hello! How are you ?</div>
                                    </div>
                                    <div class="user__item__timer">1 giờ</div>
                                </div>
                            </div>
                        </div>
                        <div class="message__box__right">
                            <div class="message__box__header">
                                <div class="message__box__header-user">
                                    <div class="user-avatar">
                                        <img src="https://picsum.photos/200/300" alt="Avatar" />
                                    </div>
                                    <div class="user-name">
                                        <div class="name">Donal Trump</div>
                                        <div class="status"><span class="dot green"></span>Online</div>
                                    </div>
                                </div>
                            </div>
                            <div class="message__box__content">
                                <div class="message__partner node_message">
                                    <div class="partner_avatar node_message_avatar">
                                        <img src="https://picsum.photos/200/300" alt="User" />
                                    </div>
                                    <div class="message__list node_message_list">
                                        <div class="message__item node_message_item"><p>sadsa</p></div>
                                        <div class="message__item node_message_item"><p>sdsad sdsad</p></div>
                                        <div class="message__item node_message_item">
                                            <p>sdsad sadsad sadsad</p>
                                            <p class="time"><span>21:46</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="message__author node_message">
                                    <div class="author_avatar node_message_avatar">
                                        <img src="https://picsum.photos/200/300" alt="User" />
                                    </div>
                                    <div class="message__list node_message_list">
                                        <div class="message__item node_message_item"><p>abc</p></div>
                                        <div class="message__item node_message_item"><p>def</p></div>
                                        <div class="message__item node_message_item recent__message">
                                            <p>ádassafsa</p>
                                            <p class="time"><span>21:46</span><span>Đã gửi</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="message__form">
                                <div class="message__form__input">
                                    <a-input class="input" size="large" />
                                    <a-button :htmlType="'button'" type="primary" size="large">Send</a-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </Content>
    </has-sidebar-layout>
</template>

<script>
import { mapActions, mapMutations } from 'vuex';
import HasSidebarLayout from '@core/layouts/HasSidebarLayout.vue';
import Content from '@core/layouts/Content.vue';
export default {
    components: {
        HasSidebarLayout,
        Content,
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
