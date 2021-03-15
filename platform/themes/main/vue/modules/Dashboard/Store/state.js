export default {
    loading: false,
    sidebarMenu: [
        {
            icon: "el-icon-s-grid",
            title: "Dashboard",
            path : '/',
            link: { name: "dashboard" }
        },
        {
            icon: "el-icon-s-order",
            title: "Todo List",
            path : '/todo-list',
            link: { name: "todo-list" }
        },
        // {
        //     icon: "el-icon-s-custom",
        //     title: "User",
        //     link: "javascript:void(0)",
        //     subs: [
        //         {
        //             icon: "el-icon-s-custom",
        //             title: "Sub 1",
        //             path : '/abc',
        //             link: { name: "login" }
        //         },
        //         {
        //             icon: "el-icon-s-custom",
        //             title: "Sub 2",
        //             path : '/abc2',
        //             link: { name: "dashboard" }
        //         }
        //     ]
        // }
    ]
};
