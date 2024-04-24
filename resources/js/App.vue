<script setup>
import {onMounted} from "vue";
import {useAuthStore} from "@/store/AuthStore.js";
import {useUserStore} from "@/store/UserStore.js";
import Header from "@/components/Header/Header.vue";

const authStore = useAuthStore()
const userStore = useUserStore()
const isToken = localStorage.hasOwnProperty('authToken')

onMounted(async () => {
    if (isToken) {
        await authStore.profile()
    }
    await userStore.getCountNotifications()
})

// if (isToken) {
//     console.log(isToken);
//     setInterval(async () => {
//        await userStore.getCountNotifications()
//     }, 60 * 1000)
// }

</script>

<template>
    <div class="max-w-96 mx-auto">

        <Header/>
        <router-view></router-view>
    </div>
</template>


