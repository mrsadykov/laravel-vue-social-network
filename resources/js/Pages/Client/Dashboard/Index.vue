<template>
    <div v-if="postsData.length >= 1">
        <PostItem
            @post_deleted="refreshPosts"
            v-for="post in postsData"
            :post="post"></PostItem>
    </div>

    <div v-else>
        <p>
            У вас пока нет статей
        </p>
    </div>
</template>

<script>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import PostItem from '@/Components/Post/PostItem.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: 'Index',
    props: {
        posts: Object
    },
    data() {
        return {
            postsData: this.posts,
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
