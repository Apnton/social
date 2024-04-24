<script setup>
import {useAuthStore} from "@/store/AuthStore.js";
import {useUserStore} from "@/store/UserStore.js";
import NotificationBell from "@/components/UI/NotificationBell.vue";

const authStore = useAuthStore()
const userStore = useUserStore()

</script>

<template>
    <header class=" my-4 px-2 flex justify-center">
        <router-link class="mr-6" v-if="authStore.isAuth" :to="{name: 'users.index'}">Users</router-link>
        <router-link class="mr-6" v-if="authStore.isAuth" :to="{name: 'posts.index'}">Personal</router-link>
        <router-link class="mr-6" v-if="authStore.isAuth" :to="{name: 'posts.feed'}">Feed</router-link>
        <router-link class="mr-6" v-if="!authStore.isAuth" :to="{name: 'login'}">Login</router-link>
        <router-link class="mr-6" v-if="!authStore.isAuth" :to="{name:'registration'}">Registration</router-link>
        <router-link class="mr-6" v-if="authStore.isAuth" :to="{name: 'logout'}">Logout</router-link>
        <NotificationBell v-if="authStore.isAuth" :count="userStore.countNotifications"/>
    </header>
</template>

<style scoped>

</style>
