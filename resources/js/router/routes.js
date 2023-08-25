import MainLayout from "../layouts/MainLayout.vue";

const routes = [
    {
        path: '/',
        component: MainLayout,
        children: [
            {
                path: "",
                redirect: "/dashboard",
                showInMenu: false,
                label: "Redirect",
            },
            {
                path: "dashboard",
                label: "Dashboard",
                component: () => import("../pages/Home.vue"),
                meta: {
                    icon: 'dashboard',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/quotes",
                label: "Quotes",
                name: "quotes",
                component: () => import("../pages/QuoteList.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/quotes/create",
                label: "Quotes",
                component: () => import("../pages/QuoteCreateUpdate.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/quotes/:id/edit",
                label: "Quotes",
                showInMenu: false,
                component: () => import("../pages/QuoteCreateUpdate.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
        ]
    },

];

export default routes;
