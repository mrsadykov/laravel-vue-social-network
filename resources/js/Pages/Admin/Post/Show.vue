<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: 'Show',
    props: {
        post: Object
    },
    data() {
        return {
            postData: this.post
        }
    },
    methods: {
        toggleLike()
        {
            axios.post(route('admin.posts.like.toggle', this.post.id))
                .then(res => {
                    console.log(res)
                    /*this.post.is_liked = res.data.is_liked
                    this.post.liked_by_profiles_count = res.data.liked_by_profiles_count*/
                    this.postData = res.data
                })
                .catch(e => {
                    console.log(e)
                })
        }
    },
    components: {
        Link
    },
    layout: AdminLayout
}
</script>

<template>
    <div>
        <div class="mb-4">
            {{ postData.title }}
        </div>

        <div class="mb-4">
            {{ postData.content }}
        </div>

        <div class="flex mb-4">
            <div v-for="image in postData.image" class="w-1/2 mb-4 mx-4">
                <img :src="image" :alt="postData.title">
            </div>
        </div>

        <div class="flex mb-4 items-center">
            <div class="mr-1">
                {{ postData.liked_by_profiles_count }}
            </div>

            <div>
                <svg @click="toggleLike" class="cursor-pointer" style="width:20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 36 36">
                    <path :fill="postData.is_liked ? '#DD2E44' : '#000000'" d="M35.885 11.833c0-5.45-4.418-9.868-9.867-9.868c-3.308 0-6.227 1.633-8.018 4.129c-1.791-2.496-4.71-4.129-8.017-4.129c-5.45 0-9.868 4.417-9.868 9.868c0 .772.098 1.52.266 2.241C1.751 22.587 11.216 31.568 18 34.034c6.783-2.466 16.249-11.447 17.617-19.959c.17-.721.268-1.469.268-2.242z"/>
                </svg>
            </div>
        </div>

        <Link class="text-blue-500" :href="route('admin.posts.index')">Вернуться в список</Link>
    </div>
</template>
