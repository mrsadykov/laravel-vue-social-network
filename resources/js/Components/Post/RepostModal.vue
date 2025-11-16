<script>
export default {
    name: "RepostModal",
    props: {
        post: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            isModalShow: false,
            repost: {},
            isRepostResultShow: false,
            repostResult: '',
            postData: this.post
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

        // showModal(post)
        // {
        //     this.isModalShow = true
        //     this.repost.postId = post.id
        // },
    },
    components: {

    }
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
</template>
