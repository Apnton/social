import {defineStore} from 'pinia';
import api from '@/api/api.js'

export const usePostStore = defineStore('postStore', {
    state: () => ({
        posts: [],
        postLimit: 2,
        currentPage: 1,
        totalPage: null,
        feeds: [],
        post: {},
        followingPosts: [],
        comments: [],
        isShowReply: null,
        isComment: null,
        isShowChildren: null,
        commentFormData: {}
    }),

    actions: {

        async getAll() {
            try {
                const result = await api.get('/api/posts/index', {
                    params: {
                        limit: this.postLimit,
                        page: this.currentPage
                    }
                })
                this.posts = result.data.items
                this.totalPage = Math.ceil(result.data?.pagination?.total / this.postLimit)

            } catch (e) {
                console.log(e);
            }
        },

        async store(data) {
            try {
                const result = await api.post('/api/posts/store', data)
                this.posts.unshift(result.data.data)
            } catch (e) {
                console.log(e);
            }
        },

        async getFollowingPosts() {
            try {
                const result = await api.get('/api/posts/following-posts')
                this.feeds = result.data.items

            } catch (e) {
                console.log(e);
            }
        },

        async getPostsByUserId(userId) {
            try {
                const result = await api.get(`/api/users/${userId}/posts`)
                this.posts = result.data.items
            } catch (e) {
                console.log(e);
            }
        },

        async toggleLike(postId, type) {
            try {
                const result = await api.post(`/api/posts/${postId}/toggle-like`)
                const post = result.data.data
                const index = this[type].findIndex(p => p.id === post.id)
                if (index !== -1) {
                    this[type][index].is_liked = post.is_liked
                    this[type][index].likes_count = post.likes_count
                }

            } catch (e) {
                console.log(e);
            }
        },

        async repost(data) {
            const result = await api.post('api/posts/repost', {
                title: data.title,
                content: data.content,
                reposted_id: data.reposted_id,
            })
        },

        async getCommentsByPostId(postId) {
            try {
                const result = await api.get(`/api/posts/${postId}/comment`)
                this.comments = result.data.data
            } catch (e) {
                console.log(e);
            }

        },

        async storeComment(data) {
            try {
                const result = await api.post('/api/posts/comment', {
                    post_id: data.post_id,
                    parent_id: data.parent_id,
                    body: data.body
                })
                return result.data
            } catch (e) {
                console.log(e);
            }
        },

        async loadMorePosts() {

            this.currentPage += 1;
            try {
                const result = await api.get('/api/posts/index', {
                    params: {
                        limit: this.postLimit,
                        page: this.currentPage
                    }
                })

                this.posts = [...this.posts, ...result.data.items]

            } catch (e) {
                console.log(e);
            }
        }


    }
})
