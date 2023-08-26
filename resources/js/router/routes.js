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
                path: "/people",
                label: "People",
                name: "people",
                component: () => import("../pages/PersonList.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/people/create",
                label: "Create Person",
                component: () => import("../pages/PersonCreateUpdate.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/people/:id/edit",
                label: "People",
                showInMenu: false,
                component: () => import("../pages/PersonCreateUpdate.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/people/:id",
                label: "People View",
                showInMenu: false,
                component: () => import("../pages/PersonView.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/addresses",
                label: "Addresses",
                name: "addresses",
                component: () => import("../pages/AddressList.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/addresses/create",
                label: "Create Addresses",
                component: () => import("../pages/AddressCreateUpdate.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
            {
                path: "/addresses/:id/edit",
                label: "Address Edit",
                showInMenu: false,
                component: () => import("../pages/AddressCreateUpdate.vue"),
                meta: {
                    icon: 'list',
                    permission: "dashboard",
                },
              
            },
        ]
    },

];

export default routes;
