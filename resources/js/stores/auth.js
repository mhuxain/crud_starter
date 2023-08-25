import { defineStore } from "pinia";
import { ref } from "vue";


export const useAuthStore = defineStore('authStore', () => {
    const authUser = ref(null)
    
    
    const fetchMe = async () => {
        return await axios.get('/api/me').then(data => data.data);
    }

    const getUser = async ( user = null ) => {
        if(user === null){
            return fetchMe()
        }
        return authUser.value
    }

    
    return {
        authUser, 
        getUser, 
        fetchMe, 
    }
})