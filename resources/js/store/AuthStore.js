import {defineStore} from 'pinia';
import api from '@/api/api.js'

export const useAuthStore = defineStore('authStore', {
    state: () => ({
        user: [],
        isAuth: localStorage.hasOwnProperty('authToken'),

    }),

    actions: {
        async login(email, password) {
            try {
                const data = await api.post('/api/auth/login', {
                    email: email,
                    password: password,
                })
                const token = data?.data.data.token

                if (token) {
                    localStorage.setItem('authToken', token)
                    this.isAuth = true
                }

                return token

            } catch (e) {
                console.log(e);
            }
        },

        async registration(credentials) {
            try {
                const data = await api.post('/api/auth/registration', {
                    name: credentials.name,
                    email: credentials.email,
                    password: credentials.password,
                    password_confirmation: credentials.password_confirmation,
                })
                return data?.data?.message

            } catch (e) {
                console.log(e);
            }
        },

        async logout() {
          try {
              const data = await api.post('/api/auth/logout')
              localStorage.removeItem('authToken')
              this.isAuth = false
          }  catch (e) {
              console.log(e);
          }
        },

        async profile() {
            try {
                const result = await api.get('/api/users/profile')
                this.user = result.data.data

            } catch (e) {
                console.log(e);
            }
        }

    }
})
