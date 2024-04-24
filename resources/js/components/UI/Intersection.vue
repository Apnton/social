<script setup>
import {defineProps, onMounted, ref} from "vue";

const props = defineProps({
    loadMore: {
        type: Function,
        required: true
    },
    currentPage: {
        type: Number
    },
    totalPage: {
        type: Number
    }
});

const trigger = ref()

onMounted(() => {
    const options = {
        rootMargin: "0px",
        threshold: 1.0,
    };

    const callback = (entries, observer) => {
        console.log(trigger);
        if (entries[0].isIntersecting && props.currentPage < props.totalPage) {
            props.loadMore();
        }
    };

    const observer = new IntersectionObserver(callback, options);
    observer.observe(trigger.value);
});
</script>

<template>
    <div ref="trigger" class="h-20 bg-green-300"></div>
</template>

<style scoped>

</style>
