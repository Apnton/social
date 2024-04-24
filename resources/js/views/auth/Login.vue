<script setup>
import {reactive} from "vue";
import {useRouter} from "vue-router";
import {useAuthStore} from "@/store/AuthStore.js";
import {toast} from "vue3-toastify";
import {notifications} from "@/config/notifications.js";

const router = useRouter()
const authStore = useAuthStore()

const credentials = reactive({
    email: '',
    password: '',
})

const login = async () => {
    const result = await authStore.login(credentials.email, credentials.password);
    if (result) {
        toast.success(notifications.login)
        await router.push({name: 'posts.index'})
    }

}

</script>

<template>
    <form @submit.prevent class="flex flex-col gap-2">
        <MyInput v-model="credentials.email" name="email" placeholder="email" type="text"/>
        <MyInput v-model="credentials.password" name="email" placeholder="Password" type="text"/>
        <MyButton @click="login">Login</MyButton>
    </form>
</template>

<style scoped>

</style>
