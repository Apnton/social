<script setup>
import {useRouter} from "vue-router";
import {useAuthStore} from "@/store/AuthStore.js";
import {onMounted} from "vue";
import {notifications} from "@/config/notifications.js";
import {toast} from "vue3-toastify";

const router = useRouter()
const authStore = useAuthStore()

onMounted(async () => {
    await authStore.logout()
    toast.success(notifications.logout)
    await router.push('/')
})
</script>

<template>
    <div>Logout</div>
</template>

<style scoped>

</style>
