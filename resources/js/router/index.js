
import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";

import { useAuthStore } from "../stores/auth";


const router = createRouter({
    history: createWebHistory(),
    routes,
});


router.beforeEach( async (to, from, next) => {

    // if( !user.isActive() ){
    //     if( to.name === 'setup' ){
    //         next()   
    //         return;
    //     }
    //     next('/user/setup')
    //     return;
    // }
    
    next();

})


export default router;
