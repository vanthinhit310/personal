export default {
    methods: {
        getAvatar(instance) {
            if (!!instance) {
                const { avatar } = instance;
                if (typeof avatar === "object" && avatar !== null) {
                    return (
                        _.get(instance, "avatar.encoded", "") ||
                        _.get(instance, "avatar_url", "")
                    );
                }
            }
            return "https://api.hubspot.com/userpreferences/v1/avatar/6c5f94576c1935a0cdd08eccab2ea50e/100";
        }
    }
};
