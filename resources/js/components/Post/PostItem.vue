<script setup>
import {toast} from "vue3-toastify";
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";
import MyLike from "@/components/UI/MyLike.vue";
import MyShare from "@/components/UI/MyShare.vue";
import MyInput from "@/components/UI/MyInput.vue";
import {usePostStore} from "@/store/PostStore.js";
import MyButton from "@/components/UI/MyButton.vue";
import MyComment from "@/components/UI/MyComment.vue";
import MyTextarea from "@/components/UI/MyTextarea.vue";
import {notifications} from "@/config/notifications.js";
import CommentList from "@/components/Comment/CommentList.vue";
import CommentForm from "@/components/Comment/CommentForm.vue";

const router = useRouter()
const postStore = usePostStore()

const props = defineProps({
    post: {
        type: Object,
        required: true
    },
    isAvailableRepost: {
        type: Boolean,
        default: false
    },
    postType: {
        type: String,
        default: 'posts'
    }
})

const isShare = ref(false)
const data = reactive({
    title: '',
    content: '',
    reposted_id: null
})
const sharePost = () => {
    isShare.value = !isShare.value
}
const repostPost = (postId) => {
    data.reposted_id = postId
    postStore.repost(data)
    toast.success(notifications.reposted)
    router.push({name: 'posts.index'})
}
const toggleComment = async (postId) => {
    if (postStore.isComment === postId) {
        postStore.isComment = null
    } else {
        postStore.isComment = postId
        postStore.commentFormData.post_id = postId
        await postStore.getCommentsByPostId(postId)
    }
}
const toggleLike = async (postId, postType) => {
    await postStore.toggleLike(postId, postType)
}


</script>

<template>
    <div class="mb-4 px-2 border-t border-t-gray-300">

        <h2 class="my-1">{{ post.title }}</h2>
        <router-link class="mb-2 text-xs block hover:opacity-70" v-if="post.user" :to="{name: 'users.show', params: {id: post.user.id}}">
            {{ post.user.name }}
        </router-link>
        <img v-if="post.image" :src="post.image" alt="image">

        <p class="mt-2 mb-2">{{ post.content }}</p>
        <div v-if="post.reposted" class="px-4 py-6 bg-gray-100 border border-gray-200 mb-2">
            <router-link class="mb-2 text-xs block hover:opacity-70" v-if="post.reposted.user" :to="{name: 'users.show', params: {id: post.reposted.user.id}}">
                {{ post.reposted.user.name }}
            </router-link>
            <img v-if="post.reposted.image" :src="post.reposted.image" alt="image">
            <p class="mt-2 mb-2">{{ post.reposted.content }}</p>
        </div>
        <div class="flex items-center justify-between mb-2">
            <div class="flex justify-end gap-1 items-center">
                <MyLike
                    @toggleLike="toggleLike(post.id, postType)"
                    :id="post.id"
                    :likeCount="post.likes_count"
                    :isLiked="post.is_liked"
                />
                <div class="flex items-center gap-1" v-if="isAvailableRepost" @click="sharePost">
                    <MyShare
                        :id="post.id"
                        :shareCount="post.reposted_by_posts_count"
                    />
                </div>
                <MyComment
                    :commentCount="post.comments_count"
                    @toggleComment="toggleComment"
                    :id="post.id"
                />
            </div>
            <div class="text-gray-300 text-xs text-right mb-2">{{ post.created_at }}</div>
        </div>
        <div v-if="isShare" class="flex flex-col gap-2">
            <MyInput v-model="data.title" name="title" type="text" placeholder="title"/>
            <MyTextarea v-model="data.content" name="content" type="text" placeholder="content"/>
            <MyButton @click="repostPost(post.id)">Submit</MyButton>
        </div>
        <CommentList
            v-for="comment in postStore.comments"
            v-if="postStore.isComment === post.id"
            :key="comment.id"
            :comment="comment"
        />
        <CommentForm v-if="postStore.isComment === post.id"/>
    </div>
</template>

<style scoped>

</style>
