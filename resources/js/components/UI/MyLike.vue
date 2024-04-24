<script setup>
const emit = defineEmits(['toggleLike']);
const props = defineProps({
    id: {
      type: Number,
      required: true
    },
    likeCount: {
        type: Number,
        default: 0
    },
    isLiked: {
        type: Boolean,
        default: false
    }
})

const toggleLike = (postId) => {
    emit('toggleLike', postId)
}

</script>

<template>
    <div class="text-gray-300 ">{{ likeCount }}</div>
    <div @click="toggleLike(id)" class="cursor-pointer flex justify-end mr-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor"
             :class="['w-5 h-5 stroke-sky-500 hover:fill-sky-400', isLiked ? 'fill-sky-400' : '']">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
        </svg>
    </div>
</template>

