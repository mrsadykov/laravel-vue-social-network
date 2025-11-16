<script>
import { Link } from '@inertiajs/vue3';
import ClientLayout from '@/Layouts/ClientLayout.vue';
import PostItem from '@/Components/Post/PostItem.vue';
import axios from 'axios';

export default {
    name: 'Show',
    props: {
        posts: {
            type: Array,
            required: false
        },
        profile: {
            type: Object,
            required: true
        },
        //isFollowed: true
    },
    data() {
        return {
            postsData: this.posts,
            isModalShow: false,
            repost: {},
            isRepostResultShow: false,
            repostResult: '',
            profileData: this.profile
            //isFollowed: this.isFollowed
        }
    },
    methods: {
        sharePost()
        {
            // создание поста
            console.log('sharePost')
            axios.post(route('client.profiles.posts.repost', this.repost.postId), this.repost)
                .then(res => {
                    console.log('sharePost axios res')
                    // показать что статья репостнута
                    this.isModalShow = false
                    this.isRepostResultShow = true
                    this.repostResult = res.data.message
                })
                .catch(e => {
                    console.log(e)
                })
        },
        showModal(post)
        {
            this.isModalShow = true
            this.repost.postId = post.id
        },
        toggleFollowing()
        {
            axios.post(route('client.profiles.followings.toggle', this.profileData.id))
                .then(res => {
                    console.log(res)
                    this.profileData.is_followed = res.data.is_followed
                })
                .catch(e => {
                    console.log(e)
                })
        }
    },
    components: {
        PostItem,
        Link
    },
    layout: ClientLayout
}
</script>

<template>
    <div v-if="isModalShow" @click="isModalShow = false" class="modal-shadow">
        <div @click.stop class="modal">
            <div class="modal-body">
                <!-- <div class="mb-4">
                    <input
                        v-model.trim="repost.title"
                        type="text"
                        placeholder="заголовок"
                        class="w-full border border-gray-200 p-4">
                </div>

                <div class="mb-4">
                    <textarea
                        v-model.trim="repost.content"
                        type="text"
                        placeholder="контент"
                        class="w-full border border-gray-200 p-4"></textarea>
                </div> -->

                <div class="mb-4">
                    <textarea v-model.trim="repost.signature"
                        type="text"
                        placeholder="Как хотите подписать репост?"
                        class="w-full border border-gray-200 p-4"></textarea>
                </div>

                <div class="mb-4">
                    <a @click.prevent="sharePost" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                        Поделиться
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div v-if="isRepostResultShow" @click="isRepostResultShow = false" class="modal-shadow">
        <div @click.stop class="modal">
            <div class="modal-body">
                {{ repostResult }}
            </div>
        </div>
    </div>

    <div>
        <div class="flex items-center">
            <div class="mr-2">
                <Link :href="route('client.chats.store')"
                    method="post"
                    :data="{ profile_ids: [ profileData.id ] }"
                    class="inline-block px-3 py-2 text-white bg-sky-600 border border-sky-600">
                    Написать
                </Link>
            </div>

            <div>
                <a @click.prevent="toggleFollowing"
                    :class="[ profileData.is_followed
                        ? 'bg-red-600 border-red-700'
                        : 'bg-emerald-600 border-emerald-700',
                        'cursor-pointer inline-block px-3 py-2 text-white border'
                    ]"
                    v-html="profileData.is_followed ? 'Отписаться' : 'Подписаться'">
                </a>
            </div>
        </div>

        <div>
            <PostItem v-for="post in postsData"
                :post="post"
                @show_modal="showModal"
                ></PostItem>
        </div>
    </div>
</template>

<style>
    .modal-shadow {
        position: fixed;
        left: 0;
        top: 0;
        background: rgba(0, 0, 0, 0.6);
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .modal {
        background: #fff;
        padding: 20px;
        width: 400px;
    }
</style>
