import {createRouter, createWebHistory} from "vue-router";

const routes = [
    {
        path: '/posts',
        component: () => import('../views/post/PersonalPosts.vue'),
        name: 'posts.index'
    },
    {
        path: '/posts/feed',
        component: () => import('../views/post/FeedPosts.vue'),
        name: 'posts.feed'
    },
    {
        path: '/users',
        component: () => import('../views/user/Index.vue'),
        name: 'users.index'
    },
    {
        path: '/users/:id',
        component: () => import('../views/user/UsersPosts.vue'),
        name: 'users.show'
    },
    {
        path: '/login',
        component: () => import('../views/auth/Login.vue'),
        name: 'login'
    },
    {
        path: '/registration',
        component: () => import('../views/auth/Registration.vue'),
        name: 'registration'
    },
    {
        path: '/logout',
        component: () => import('../views/auth/Logout.vue'),
        name: 'logout'
    },
    {
        path: '/chat/:id',
        component: () => import('../views/chat/Chat.vue'),
        name: 'chat'
    },
]
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL || '/'),
    routes
})
router.beforeEach((to, from, next) => {

    const token = localStorage.getItem('authToken')

    if (!token) {
        if (to.path === '/login' || to.path === '/registration') {
            return next()
        } else {
            return next({
                path: '/login'
            })
        }
    }

    if (to.path === '/login' || to.path === '/registration' && token) {
        return next({
            path: '/'
        })
    }

    next()
})

export default router;
