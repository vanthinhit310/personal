export default {
    getCurrentUser: state => {
        return state.currentUser;
    },
    getAvatar: state => {
        const { currentUser } = state;
        if (currentUser) {
            const { avatar } = currentUser;
            if (typeof avatar === "object" && avatar !== null) {
                return (
                    _.get(currentUser, "avatar.encoded", "") ||
                    _.get(currentUser, "avatar_url", "")
                );
            }
        }
        return "https://api.hubspot.com/userpreferences/v1/avatar/6c5f94576c1935a0cdd08eccab2ea50e/100";
    }
};
