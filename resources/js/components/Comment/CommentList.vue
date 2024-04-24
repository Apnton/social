<script setup>
import {usePostStore} from "@/store/PostStore.js";
import CommentForm from "@/components/Comment/CommentForm.vue";
import {ref} from "vue";

const postStore = usePostStore()
const props = defineProps({
    comment: {
        type: Object,
        required: true
    },
})

const isShowChildren = ref(false)
const toggleChildren = () => {
    isShowChildren.value = !isShowChildren.value
}


const reply = (commentId) => {

    if (postStore.isShowReply === commentId) {
        postStore.isShowReply = null
    } else {
        postStore.isShowReply = commentId
        postStore.commentFormData.parent_id = commentId
    }
};
const isReply = (commentId) => {
    return postStore.isShowReply === commentId
}

</script>

<template>
    <div  class="flex flex-col gap-1 px-2 py-1 bg-gray-50 border rounded-xl mb-2 pl-2">
        <div class="text-xs ">{{ comment?.user?.email }}</div>
        <div>{{ comment.body }}</div>
        <div class="flex items-center justify-between">
            <button @click="reply(comment.id)"
                    class="text-sky-400 hover:opacity-50 transition duration-300 ease-in-out text-xs">reply
            </button>
            <div class="text-xs self-end">{{ comment.created_at }}</div>
        </div>
        <button v-if="comment.children.length" @click="toggleChildren"
                class="text-sky-400 hover:opacity-50 transition duration-300 ease-in-out text-xs">
            {{ isShowChildren ? 'Hide Replies' : 'Show Replies' }}
        </button>
    </div>
    <div :class="['mb-2', isReply(comment.id) ? '': 'hidden' ]">
        <CommentForm/>
    </div>

    <div class="ml-2" v-show="isShowChildren">
        <CommentList
            v-for="commentChildren in comment.children"
            v-if="comment.children"
            :key="comment.id"
            :comment="commentChildren"/>
    </div>

</template>

<style scoped>

</style>
