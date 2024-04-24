<script setup>

const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    placeholder: {
        type: String,
        required: false,
        default: ''
    },
    type: {
        type: String,
        required: true,
        default: 'text'
    },
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String
    }

})

const inputValue = (e) => {
    emit('update:modelValue', e.target.value);
}

</script>

<template>
    <input
        :type="type"
        :name="name"
        :placeholder="placeholder"
        :value="modelValue"
        @input="inputValue"
        class="py-2 px-3  border border-gray-300 rounded-3xl focus:outline-blue-300"
        type="text"
    >
</template>

<style scoped>

</style>
