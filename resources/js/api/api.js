import axios from "axios";
import router from "@/router";
import {toast} from "vue3-toastify";

const api = axios.create({
    baseURL: 'http://localhost:8876'
})

api.interceptors.request.use(config => {
    return configurationAxios(config)
}, error => {
    console.error(error)
})

api.interceptors.response.use(config => {
    return configurationAxios(config)
}, error => {

    if (error.response.status === 401 && localStorage.hasOwnProperty('authToken')) {
        localStorage.removeItem('authToken')
        router.push('/login');
    }

    if (error.response.status === 401) {
        router.push('/login');
    }



    if (error.response.status === 422) {
        const errorMessage = Object.values(error.response.data.errors)[0];
        toast.error(errorMessage, {autoClose: 2000});
    }
})

export default api;

function configurationAxios(config) {

    const token = localStorage.getItem('authToken')

    if (token) {
        config.headers.Authorization = `Bearer ${token}`
        config.headers['X-Socket-ID'] =  Echo.socketId()
    }

    return config;
}
