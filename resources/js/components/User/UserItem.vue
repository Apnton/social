<script setup>
import {useChatStore} from "@/store/ChatStore.js";
import {useRoute, useRouter} from "vue-router";
import {useAuthStore} from "@/store/AuthStore.js";
import {onMounted} from "vue";

const emit = defineEmits(['subscribe']);
const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})

const chatStore = useChatStore();
const authStore = useAuthStore()
const route = useRouter()

const getAvatar = (name) => {
    return name.substring(0, 2).toUpperCase()
}

const subscribe = (userId) => {
    emit('subscribe', userId)
}

const storeChat = async (userId) => {
    await chatStore.storeChat(userId, authStore?.user?.id)
    route.push({name: 'chat', params: {id: chatStore.chat_id}})

}


</script>

<template>
    <div class="px-2 py-3 border-t border-t-gray-300 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="bg-gray-300 w-11 h-11 rounded-full flex justify-center items-center">
                {{ getAvatar(user.name) }}
            </div>
            <div>
                <router-link :to="{ name: 'users.show', params: { id: user.id }}">
                    <div>{{ user.name }}</div>
                    <div class="text-xs">{{ user.email }}</div>
                </router-link>

            </div>
        </div>
        <div class="flex items-center gap-3">
            <button
                @click="subscribe(user.id)"
                :class="[user.is_subscribe ? 'text-gray-400' : 'text-sky-400 ','hover:opacity-50 transition duration-300 ease-in-out']"
            >
                {{ user.is_subscribe ? 'Unsubscribe' : 'Subscribe' }}
            </button>
           <div  class="flex items-center gap-1 relative" @click="storeChat(user.id)">

                <svg class="w-5 h-5 cursor-pointer stroke-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.068.157 2.148.279 3.238.364.466.037.893.281 1.153.671L12 21l2.652-3.978c.26-.39.687-.634 1.153-.67 1.09-.086 2.17-.208 3.238-.365 1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
               <div v-if="user.unread_messages_count > 0" class="text-xs bg-sky-400 px-1 rounded-full text-white text-center absolute -top-2 left-4 ">{{user.unread_messages_count}}</div>

           </div>
        </div>

    </div>
</template>

<style scoped>

</style>
