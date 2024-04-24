<script setup>
const emit = defineEmits(['update:modelValue']);
const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
        default: ''
    },
    rows: {
        type: String,
        required: false,
        default: '4'
    },
    cals: {
        type: String,
        required: false,
        default: '50'
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
    <textarea
        :placeholder="placeholder"
        :rows="rows"
        :cols="cals"
        @input="inputValue"
        :value="modelValue"
        class="px-3 py-1 border border-gray-300 rounded-3xl focus:outline-blue-300"></textarea>
</template>

<style scoped>

</style>
