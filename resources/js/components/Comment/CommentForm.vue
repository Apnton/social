<script setup>
import MyButton from "@/components/UI/MyButton.vue";
import MyTextarea from "@/components/UI/MyTextarea.vue";
import {usePostStore} from "@/store/PostStore.js";
import {toast} from "vue3-toastify";
import {notifications} from "@/config/notifications.js";
import {ref} from "vue";

const postStore = usePostStore()
const body = ref('')
const addComment = async () => {
    postStore.commentFormData.body = body.value
    const result = await postStore.storeComment(postStore.commentFormData)
    if (result) {
        toast.success(notifications.comment)
        postStore.isShowReply = null
        postStore.isComment = null
        await postStore.getCommentsByPostIs(postStore.commentFormData.post_id)
    }

}

</script>

<template>
    <div class="flex flex-col gap-2">
        <MyTextarea
            v-model="body"
            name="body"
            type="text"
            placeholder="message"
        />
        <MyButton @click="addComment">Submit</MyButton>
    </div>
</template>

<style scoped>

</style>
