<script setup>
import { onMounted, ref } from "vue";
import { useAuthStore } from "../stores/auth.js";
import routes  from "../router/routes.js";
import { computed } from "@vue/reactivity";


const user = ref({});

const leftDrawerOpen = ref(false);

const authStore = useAuthStore();

onMounted(async () => {
    // user.value = await authStore.getUser();
});

const hasPermission = computed( () =>  (permission) => {
    return true;
    // return authStore.userHasPermission(permission)
})

const toggleLeftDrawer = () => {
    leftDrawerOpen.value = !leftDrawerOpen.value;
};
</script>
<template>
    <q-layout view="lhh lpR fFf">
        <q-header class="text-black bg-none" style="background: transparent !important;">
            <q-toolbar>
                <q-btn v-if="leftDrawerOpen" dense round unelevated icon="menu_open" @click="toggleLeftDrawer" />
                <q-btn v-else dense round unelevated icon="menu" @click="toggleLeftDrawer" />
                <q-toolbar-title>
                    <span v-if="user?.type === 'EFAAS_USER'">
                        {{ $route.meta?.label }}
                    </span>
                    <span v-else>
                        {{ $route.meta?.label_for_aasandha_users ?? $route.meta?.label }}
                    </span>
                </q-toolbar-title>
         
                        
                
            </q-toolbar>
        </q-header>

        <q-drawer class="relative " :class="$q.screen.lt.md ? 'bg-white': 'bg-grey-2 q-pa-md'" show-if-above v-model="leftDrawerOpen" side="left" :width="312" 
            style="max-height: 100vh;"
            
            >
            <q-scroll-area style="height: calc(100% - 250px)">
                <div class="q-pa-sm" >
                    <div class="q-pt-lg q-px-md q-pb-sm text-grey-7 text-caption">MENU</div>
             
                    <q-list :key="i" v-for="(route, i) in routes[0].children" >
                        <q-expansion-item 
                        :icon="route?.meta?.icon"
                        style="border-radius: 10px;"
                            v-if="hasPermission(route?.meta?.permission) && Array.isArray(route.children) && route.children.length > 0" 
                            >

                            <template v-slot:header>
                                <q-item-section >
                                    <div class="row items-center">

                                        <q-icon size="sm" :name="route?.meta?.icon" />
                                        <div class="q-pl-md">
                                            {{ route.label }}
                                        </div>
                                    </div>
                                </q-item-section>
                                
                            </template>
                            <q-list>
                                <template :key="child.name" v-for="child in route.children">
                                    <q-item 
                                    style="border-radius: 10px;" 
                                    active-class="text-primary bg-green-active"
                                    v-if="hasPermission(child.meta?.permission)" 
                                    clickable v-ripple :to="child.menu_link ?? child.path">
                                        <q-item-section class="q-pl-md">
                                            <span>
                                                {{ child.meta?.label }}
                                            </span>
                                            
                                        </q-item-section>
                                    </q-item>
                                </template>
                            </q-list>
                        </q-expansion-item>
                        <q-item v-if="route.showInMenu !== false"
                        :icon="route?.meta?.icon"
                        style="border-radius: 10px;" 
                                    active-class="text-primary bg-green-active"
                                    clickable v-ripple :to="route.path ?? '/'"
                        >
                        <div class="row items-center">
                            <q-icon size="sm" :name="route?.meta?.icon" />
                            <div class="q-pl-md">
                                {{ route.label }}
                            </div>
                            </div>
                        </q-item>
                    </q-list>

                    
                    


                </div>

               
                
            </q-scroll-area>
            
         
        </q-drawer>

        <q-page-container class="bg-grey-2">
            <q-scroll-area style="height: 100vh;">
                <router-view />
            </q-scroll-area>
        </q-page-container>
    </q-layout>
</template>

<style>
body{
    overflow: hidden;
}

.q-expansion-item .q-focus-helper, .q-expansion-item .q-hoverable {
    border-radius: 10px; 
  }

  .bg-green-active{
    background-color: #dde3e1;
  }
</style>
