import {defineStore} from "pinia";
import api from "@/api/api.js";

export const useUserStore = defineStore('userStore', {
    state: () => ({
        users: [],
        statistic: [],
        userIdForStatistic: null,
        profile: {},
        countNotifications: null,
        notifications: [],
        notificationLimit: 4,
        currentPage: 1,
        totalPage: null,
    }),

    actions: {
        async getAll() {
            try {
                const result = await api.get('/api/users/list')
                this.users = result.data.items
            } catch (e) {
                console.log(e);
            }
        },

        async subscribe(userId) {
            try {
                const result = await api.get(`/api/users/${userId}/toggle-following`)
                const userResponse = result.data.data
                const index = this.users.findIndex(user => user.id === userResponse.id)
                if (index !== -1) {
                    this.users[index].is_subscribe = userResponse.is_subscribe
                }

            } catch (e) {
                console.log(e);
            }
        },

        async getUserStatisticById(userId) {
            try {
                const result = await api.get(`/api/users/${userId}/statistic`)
                this.statistic = result.data.data
            } catch (e) {
                console.log(e);
            }
        },
        async getCountNotifications() {
            try {
                const result = await api.get(`/api/users/count-notifications`)
                this.countNotifications = result.data.data
            } catch (e) {
                console.log(e);
            }
        },

        async getNotifications(filterType) {
            const type = filterType ? filterType : ''
            try {
                const result = await api.get(`/api/users/notifications`, {
                    params: {
                        type: type,
                        limit: this.notificationLimit,
                        page: this.currentPage
                    }
                })
                this.notifications = result.data.items
                this.totalPage = Math.ceil(result.data?.pagination?.total / this.notificationLimit)
            } catch (e) {
                console.log(e);
            }
        },

        async loadMoreNotifications(filterType) {
            this.currentPage += 1;
            const type = filterType ? filterType : ''
            try {
                const result = await api.get(`/api/users/notifications`, {
                    params: {
                        type: type,
                        limit: this.notificationLimit,
                        page: this.currentPage
                    }
                })
                this.notifications = [...this.notifications, ...result.data.items]
            } catch (e) {
                console.log(e);
            }
        }
    }
})
