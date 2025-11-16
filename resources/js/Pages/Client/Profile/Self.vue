<template>
    <div>
        <PostItem @post_deleted="refreshPosts" v-for="post in postsData" :post="post"></PostItem>
    </div>
</template>

<script>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import PostItem from '@/Components/Post/PostItem.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Self',
    props: {
        posts: {
            type: Array,
            required: false
        }
    },
    data() {
        return {
            postsData: this.posts
        }
    },
    methods: {
        refreshPosts(post) {
            this.postsData = this.postsData.filter(postItem => postItem !== post)
        }
    },
    components: {
        PostItem,
        Link
    },
    layout: ClientLayout
}
</script>
