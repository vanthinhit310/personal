export default {
    loading: false,
    sidebarMenu: [
        {
            icon: "dashboard",
            title: "Dashboard",
            link: { name: "dashboard" }
        },
        {
            icon: "user",
            title: "User",
            link: "javascript:void(0)",
            subs: [
                {
                    icon: "user",
                    title: "Sub 1",
                    link: { name: "dashboard" }
                },
                {
                    icon: "user",
                    title: "Sub 2",
                    link: { name: "dashboard" }
                },
                {
                    icon: "user",
                    title: "Sub 3",
                    link: { name: "dashboard" }
                }
            ]
        }
    ]
};
