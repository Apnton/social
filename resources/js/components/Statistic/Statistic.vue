<script setup>
import {onMounted} from "vue";
import {useUserStore} from "@/store/UserStore.js";
import {useAuthStore} from "@/store/AuthStore.js";
import {useRoute} from "vue-router";


const userStore = useUserStore()
const authStore = useAuthStore();
const route = useRoute()


onMounted(async () => {
    const userId = route.name === 'users.show' ? route.params.id : authStore?.user?.id
    await userStore.getUserStatisticById(userId)
})
</script>

<template>
    <div class="flex justify-between gap-2">
        <div>Followers {{ userStore.statistic?.subscribers_count }}</div>
        <div>Following {{ userStore.statistic?.followings_count }}</div>
        <div>Posts {{ userStore.statistic?.posts_count }}</div>
        <div>Likes {{ userStore.statistic?.likes_count }}</div>
    </div>
</template>

<style scoped>

</style>
