<script setup>
import {onMounted} from "vue";
import {usePostStore} from "@/store/PostStore.js";
import PostItem from "@/components/Post/PostItem.vue";

const postStore = usePostStore()

onMounted(async () => {
    await postStore.getFollowingPosts()
})

</script>

<template>
    <div>
        <div v-for="post in postStore.feeds">
            <PostItem
                :postType="'feeds'"
                :isAvailableRepost="true"
                :post="post"
                :key="post.id"/>
        </div>
    </div>
</template>
