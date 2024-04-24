<script setup>
import {onMounted} from "vue";
import {useUserStore} from "@/store/UserStore.js";
import UserItem from "@/components/User/UserItem.vue";
import {useAuthStore} from "@/store/AuthStore.js";

const userStore = useUserStore();
const authStore = useAuthStore()

const subscribeHandle = async (userId) => {
    await userStore.subscribe(userId)
}

onMounted(async () => {
    await userStore.getAll()
    window.Echo.channel(`store-message-status.${authStore?.user?.id}`)
        .listen('.store-message-status', res => {
            userStore.users.map(item => {
                if (res.user_id === item.id) {
                    item.unread_messages_count = res.count
                }
            })

        })
})


</script>

<template>
    <div>
        <div v-for="user in userStore.users">
            <div class="mb-2">
                <UserItem @subscribe="subscribeHandle" :user="user" :key="user.id"/>
            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
