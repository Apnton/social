<script setup>
import {onMounted, reactive} from "vue";
import {usePostStore} from "@/store/PostStore.js";
import PostItem from "@/components/Post/PostItem.vue";
import UploadImage from "@/components/UI/UploadImage.vue";
import {useAuthStore} from "@/store/AuthStore.js";
import Statistic from "@/components/Statistic/Statistic.vue";
import InfiniteLoading from "v3-infinite-loading";
import api from "../../api/api.js";

const postStore = usePostStore()
const authStore = useAuthStore();

const data = reactive({
    title: '',
    content: '',
    image: ''
})
const uploadImage = (file) => {
    data.image = file
}
const storePost = async () => {

    const formData = new FormData
    formData.append('title', data.title)
    formData.append('content', data.content)
    formData.append('image', data.image)
    await postStore.store(formData)

    data.title = ''
    data.content = ''
    data.image = ''

    /*
        TODO temporary solution
     */
    const cancelImage = document.getElementById('cancel')
    cancelImage.click()

}
onMounted(async () => {
    await postStore.getAll();
   const res = await api.get('/api/test')
})

const loadData = async ($state) => {
    await postStore.loadMorePosts()
    if (postStore.currentPage === postStore.totalPage) {
        $state.complete()
    }
}
</script>

<template>
    <div>
        <div class="mb-2">
            <Statistic
                v-if="authStore?.isAuth && authStore?.user?.id"
            />
        </div>
        <form @submit.prevent class="flex flex-col gap-2 mb-4">
            <MyInput v-model="data.title" name="title" type="text" placeholder="title"/>
            <MyTextarea v-model.trim="data.content" name="content" placeholder="content"/>
            <UploadImage @UploadImage="uploadImage"/>
            <MyButton @click="storePost">Submit</MyButton>
        </form>
        <div>
            <div v-for="post in postStore.posts">
                <PostItem :post="post" :key="post.id"/>
            </div>
        </div>
        <InfiniteLoading v-if="postStore.posts?.length" @infinite="loadData" />
    </div>
</template>

<style scoped>

</style>
