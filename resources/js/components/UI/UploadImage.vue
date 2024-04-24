<script setup>
import {ref} from "vue";

const emit = defineEmits(['uploadImage']);

const url = ref('')
const image = ref('')

const uploadImage = (e) => {
    const render = new FileReader()
    render.onload = () => {
        url.value = render.result
        image.value = e.target.files[0]

    }
    render.readAsDataURL(e.target.files[0])
    emit('uploadImage', e.target.files[0]);
}
const cancelImage = () => {
    url.value = ''
}


</script>

<template>
    <div>
        <div class="flex justify-end mb-2">
            <label
                v-if="!url"
                class="p-2 bg-blue-400 rounded-full cursor-pointer ml-auto inline-block text-white"
                for="file">
                Image
            </label>

            <label
                id="cancel"
                @click="cancelImage" v-if="url"
                class="p-2 bg-blue-400 rounded-full cursor-pointer ml-auto inline-block text-white">
                Cancel
            </label>
        </div>

        <input
            @input="uploadImage"
            class="hidden"
            type="file"
            placeholder="image"
            id="file"
        >
    </div>
    <div v-if="url" class="mb-3">
        <img :src="url">
    </div>


</template>

<style scoped>

</style>
