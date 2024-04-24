<script setup>
import {useRoute} from "vue-router";
import {onMounted} from "vue";
import PostItem from "@/components/Post/PostItem.vue";
import {usePostStore} from "@/store/PostStore.js";
import {useAuthStore} from "@/store/AuthStore.js";
import Statistic from "@/components/Statistic/Statistic.vue";

const router = useRoute()
const postStore = usePostStore()
const authStore = useAuthStore();

onMounted(async () => {
    await postStore.getPostsByUserId(router.params.id);
})

const toggleLike = async (postId) => {
    await postStore.toggleLike(postId)
}
</script>

<template>
    <div>
        <div class="mb-2">
            <Statistic
                v-if="authStore.isAuth && authStore?.user?.id"
            />
        </div>

        <div v-for="post in postStore.posts">
            <PostItem
                :isAvailableRepost="true"
                @toggleLike="toggleLike"
                :post="post"
                :key="post.id"/>
        </div>
    </div>
</template>

<style scoped>

</style>
