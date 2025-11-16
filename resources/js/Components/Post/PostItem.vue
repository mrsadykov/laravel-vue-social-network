<template>
    <div class="mb-4 mx-auto w-1/2 p-4 border border-gray-200 bg-white">
        <div v-if="post.signature" class="mb-4">
            Repost: {{ post.signature }}
        </div>

        <div :class="postSignature">
            <div>
                <template v-if="post.parent_id">
                    <Link :href="route('client.posts.show', post.parent_id)">
                        <h3>{{ post.title }}</h3>
                    </Link>
                </template>
                <template v-else>
                    <Link :href="route('client.posts.show', post.id)">
                        <h3>{{ post.title }}</h3>
                    </Link>
                </template>
            </div>

            <div v-for="image in post.images">
                <img :src="image.url" :alt="post.title">
            </div>

            <div>
                {{ post.content }}
            </div>

            <div class="flex justify-end">
                <Link class="hover:underline text-gray-600 text-sm cursor-pointer"
                    :href="route('client.profiles.show', post.profile_id)">
                    {{ post.profile_login }}
                </Link>
            </div>
        </div>

        <div class="flex justify-between items-center mt-4">
            <div v-if="isCanDelete">
                <span @click="destroyPost" class="text-red-600">Удалить</span>
            </div>

            <div v-if="!post.signature" class="cursor-pointer">
                <svg @click="showModal" class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186a2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185a2.25 2.25 0 0 0-3.933 2.185Z"/></svg>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    name: "PostItem",
    props: {
        post: Object
    },
    computed: {
        postSignature()
        {
            return this.post.signature ? 'mb-4 mx-auto p-4 border border-gray-200 bg-red' : '';
        },
        // не чистый код!!!
        isCanDelete()
        {
            return this.$page.props.auth.user.profile.id === this.post.profile_id
        }
    },
    methods: {
        destroyPost() {
            axios.delete(route('client.posts.destroy', this.post.id))
                .then(res => {
                    console.log(res)

                    // emit - позволяет создать кастомное событие
                    this.$emit('post_deleted', this.post)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        showModal()
        {
            this.$emit('show_modal', this.post)
        }
    },
    components: {
        Link
    }
}
</script>
