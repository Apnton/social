<script setup>
import {useAuthStore} from "@/store/AuthStore.js";
import MyInput from "@/components/UI/MyInput.vue";
import MyButton from "@/components/UI/MyButton.vue";
import {useRouter} from "vue-router";
import {reactive} from "vue";
import {toast} from "vue3-toastify";

const router = useRouter()
const authStore = useAuthStore()

const credentials = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})
const registration = async () => {
    const message = await authStore.registration(credentials)

    if (message) {
        toast.success(message, {
            autoClose: 2000,
            onClose: () => {
                router.push('/login')
            }
        })
    }
}

</script>

<template>
    <form @submit.prevent class="flex flex-col gap-2">
        <MyInput v-model="credentials.name" name="name" placeholder="name" type="text"/>
        <MyInput v-model="credentials.email" name="email" placeholder="email" type="text"/>
        <MyInput v-model="credentials.password" name="email" placeholder="Password" type="text"/>
        <MyInput v-model="credentials.password_confirmation" name="email" placeholder="Password confirmation" type="text"/>
        <MyButton @click="registration">Registration</MyButton>
    </form>
</template>
