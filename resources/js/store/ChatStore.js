import {defineStore} from "pinia";
import api from "@/api/api.js";
import {useAuthStore} from "@/store/AuthStore.js";


export const useChatStore = defineStore('chatStore', {
    state: () => ({
        messages: []

    }),
    actions: {
        async storeChat(userId, authUserId) {

            try {
                const result = await api.post('/api/chats/store-chat', {
                    users: [userId, authUserId]
                })
                this.chat_id = result.data.data.chat_id
            } catch (e) {
                console.log(e);
            }
        },

        async getMessagesByChatId(id) {
            try {
                const result = await api.get(`/api/chats/${id}/messages?limit=8`)
                this.messages = result.data.items
            } catch (e) {
                console.log(e);
            }
        },

        async loadMoreByChat(id, page) {
            try {
                const result = await api.get(`/api/chats/${id}/messages?limit=8&page=${page}`)
                this.messages.push(...result.data.items)
            } catch (e) {
                console.log(e);
            }
        },

        async storeMessage(message, chatId) {
            try {
                const result = await api.post(`/api/chats/store-message`, {
                    chat_id: chatId,
                    body:message
                })
                this.messages.unshift(result.data.data)
            } catch (e) {
                console.log(e);
            }
        }
    }
})
