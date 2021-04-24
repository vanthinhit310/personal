export default {
    loading: false,
    sidebarMenu: [
        {
            icon: "el-icon-s-grid",
            title: "Dashboard",
            path: "/",
            link: {name: "dashboard"}
        },
        {
            icon: "el-icon-paperclip",
            title: "Task Assign",
            path: "/tasks",
            link: {name: "tasks"}
        },
        {
            icon: "el-icon-cloudy   ",
            title: "Google API",
            link: "javascript:void(0)",
            subs: [
                {
                    icon: 'el-icon-picture',
                    title: "Google Photos",
                    path: '/google/photo',
                    link: {name: "google.photo"}
                }
            ]
        }
    ],
};
