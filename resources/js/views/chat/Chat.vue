<script setup>

import {useChatStore} from "@/store/ChatStore.js";
import MyInput from "@/components/UI/MyInput.vue";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";
import MyButton from "@/components/UI/MyButton.vue";

const chatStore = useChatStore()
const route = useRoute()
const body = ref();
const page = ref(1)

const storeMessage = async () => {
    await chatStore.storeMessage(body.value, route.params.id)
    body.value = ''
}

onMounted(async () => {
    const chatId = route.params.id
    await chatStore.getMessagesByChatId(chatId)

    window.Echo.channel(`store-message.${chatId}`)
        .listen('.store-message', res => {
            res.message.is_owner = false
            chatStore.messages.unshift(res.message)
        })
})

const loadMore = () => {

    chatStore.loadMoreByChat(route.params.id, ++page.value)
}
</script>

<template>
    <div>
        <div class="flex flex-col gap-2 px-2 mb-2">

            <a @click.prevent="loadMore()" class="text-center text-sky-400 mb-2" href="">load more</a>
            <template v-for="message in chatStore.messages.slice().reverse()">
                <div
                    :class="['p-2 w-2/3 rounded-xl', message.is_owner ? 'self-end bg-sky-100 text-right' : 'self-start bg-green-100 text-left' ]">

                    <p class="mb-2">{{ message.body }}</p>
                    <p :class="['text-xs', message.is_owner ? 'text-right' : 'text-left']">{{ message.time }}</p>
                </div>

            </template>
        </div>

        <form @submit.prevent class="flex flex-col gap-2">
            <MyInput v-model="body" name="body" type="text" placeholder="send message"/>
            <MyButton type="submit" @click="storeMessage" @keyup.enter="storeMessage">Send</MyButton>
        </form>
    </div>

</template>

<style scoped>

</style>
