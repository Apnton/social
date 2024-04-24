<script setup>
import {onMounted, ref, watch} from "vue";
import {useUserStore} from "@/store/UserStore.js";
import {useRoute} from "vue-router";
import InfiniteLoading from "v3-infinite-loading";


const props = defineProps({
    count: {
        type: Number,
        default: 0
    }
})

const storeUser = useUserStore()
const isShowNotifications = ref(false)
const route = useRoute()
const filerType = ref('')

const toggleNotifications = async () => {
    isShowNotifications.value = !isShowNotifications.value
}

watch(() => route.path, () => {
    isShowNotifications.value = false
})

onMounted(async () => {
    await storeUser.getNotifications();
});

const filter = async (type) => {
    filerType.value = type
    storeUser.currentPage = 1
    await storeUser.getNotifications(type)
}

const loadData = async ($state) => {
    if (storeUser.currentPage <= storeUser.totalPage) {
        await storeUser.loadMoreNotifications(filerType.value)
    }
}
</script>

<template>
    <div class="relative">

        <div class="absolute left-5 bottom-3 text-xs text-sky-400">{{ count }}</div>
        <svg @click="toggleNotifications" class="w-6 h-6 cursor-pointer stroke-gray-500"
             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
        </svg>
        <div v-show="isShowNotifications"
             class="absolute right-1 bg-white p-2 w-[300px] shadow-lg shadow-sky-300/20 mt-2">
            <div class="flex justify-between mb-2 px-2 border-b py-2">
                <div @click="filter('')" class="cursor-pointer hover:opacity-70">All</div>
                <div @click="filter('read')" class="cursor-pointer hover:opacity-70">Read</div>
                <div @click="filter('unread')" class="cursor-pointer hover:opacity-70">Unread</div>
            </div>
            <ul class="overflow-y-scroll max-h-24">
                <li v-for="notification in storeUser.notifications" :key="notification.id" class="px-2 mb-2">
                    <div>{{ notification.content }}
                        <router-link v-if="notification?.data?.userId" class="cursor-pointer text-gray-400 "
                                     :to="{name: 'users.show', params: {id: notification?.data?.userId}}">
                            {{ notification.data?.name }}
                        </router-link>
                    </div>
                </li>
                <InfiniteLoading @infinite="loadData"/>
            </ul>


        </div>

    </div>
</template>

<style scoped>

</style>
