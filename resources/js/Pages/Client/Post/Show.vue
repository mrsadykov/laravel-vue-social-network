<template>
    <div class="mb-4 mx-auto w-1/2 p-4 border border-gray-200 bg-white">
        <div>
            <h1>{{ postData.title }}</h1>
        </div>

        <div class="my-2">
<!--            {{ name }}-->
<!--            {{ person.name }}-->
        </div>

        <div>
<!--            Person name: {{ person.name }} and age: {{ person.age }}-->
        </div>

        <div>
<!--            Another person name: {{ anotherPerson.name }} and age: {{ anotherPerson.age }}-->
        </div>

<!--        <div @click="changeName" class="my-2">-->
<!--            Change name-->
<!--        </div>-->

<!--        <div @click="clearPerson" class="my-2">-->
<!--            Clear person-->
<!--        </div>-->

        <div v-for="image in postData.images">
            <img :src="image.url" :alt="postData.title">
        </div>

        <div>
            {{ postData.content }}
        </div>

        <div class="flex justify-end">
            <Link class="hover:underline text-gray-600 text-sm cursor-pointer"
                :href="route('client.profiles.show', postData.profile_id)">
                {{ postData.profile_login }}
            </Link>
        </div>
    </div>

    <div v-if="commentsData.data.length >= 1" class="mb-4 mx-auto w-1/2 p-4 border border-gray-200 bg-white">
        <div class="mb-4">
            <h3>Комментарии</h3>
        </div>

        <CommentItem v-for="commentItem in commentsData.data"
            :commentItem="commentItem"
            @add-answer="(commentId) => addAnswer(commentId)"
            @store-comment="(comment) => storeComment(comment, commentItem)"
            @toggle-comment-like="(comment) => toggleCommentLike(comment)"
            @delete-comment="(commentId, type) => deleteComment(commentId, type)"
            :key="commentItem.id">
        </CommentItem>

        <div class="mb-4" v-if="commentsData.meta.links.length > 3">
            <template v-for="link in commentsData.meta.links">
                <div
                    @click.prevent="changePage(link)"
                    :class="[ link.active ? 'border-sky-700 bg-sky-600 text-white' : 'border-gray-200 bg-white text-gray-600', 'inline-block px-2 py-1 border mr-2 cursor-pointer']"
                    v-html="link.label"
                    v-if="link.url !== null">
                </div>
            </template>
        </div>
    </div>

    <div class="mb-4 mx-auto w-1/2 p-4 border border-gray-200 bg-white">
        <div>
            <textarea class="border border-gray-200 w-full" v-model="comment.content" placeholder="Комментарий"></textarea>
        </div>
        <div class="mb-4">
            <a @click.prevent="storeComment" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                Добавить
            </a>
        </div>
    </div>
</template>

<script setup>

import {reactive, ref} from "vue";
import axios from "axios";

// composition api
// опции (options)
// defineOptions({
//     name: 'Show from composition'
// })

// пропсы (props)
// const { post, comments } = defineProps({
//     post: {
//         type: Object,
//         required: true
//     },
//     comments: {
//         type: Object,
//         required: false
//     }
// })

// обычная переменная, при клике ничего не меняется
// const name = 'Boris'

// добавляем реактивности и name уже объект
//const name = ref('Boris')
// методы, 1 контекст - this не нужен
// const changeName = function () {
//     name.value = 'Ivan'
// }

// const person = ref({
//     name: 'Boris',
//     age: 33
// })

// const changeName = function () {
//     person.value.name = 'Ivan'
// }

// reactive - будет создана копия объекта
// reactive - реактивный объект
// const person = reactive({
//     name: 'Boris',
//     age: 33
// })
//
// let anotherPerson = reactive({})
//
// const changeName = function () {
//     //person.name = 'Ivan'
//
//     // person перезаписываем в anotherPerson
//     Object.assign(anotherPerson, person)
// }
//
// const clearPerson = function () {
//     Object.assign(person, { name: '', age: null })
// }

// свойства (что в data)
//const comment = reactive({})

// методы
// const storeComment = function (comment, commentItem)
// {
//     let commentData = {}
//     // ответ к комментарию
//     if (commentItem) {
//         // очистка основного комментария
//         this.comment = {}
//         commentData = comment
//     } else {
//         commentData = this.comment
//     }
//
//     axios.post(route('client.posts.comments.store', this.postData.id), commentData)
//         .then(res => {
//             this.comment = {}
//             this.getComments()
//         })
//         .catch(e => {
//             console.log(e)
//         })
// }


</script>

<script>
import CommentItem from '@/Components/Comment/CommentItem.vue';
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';
import logger from "pusher-js/src/core/logger.js";

export default {
    //name: 'Show',
    props: {
        post: Object,
        comments: Object
    },
    data() {
        return {
            comment: {},
            commentsData: this.comments,
            postData: this.post,
            commentsPagination: {}
        }
    },
    // для преобразований (как геттер) // если что-то нужно несколько раз выводить, то использовать computed // измененное значение выводит
    // на практике замена тернарных операторов
    computed: {
        postTitle()
        {
            console.log('computed')
            return this.postData.title
        }
    },
    methods: {
        storeComment(comment, commentItem)
        {
            console.log('storeComment')

            let commentData = {}
            // ответ к комментарию
            if (commentItem) {
                // очистка основного комментария
                this.comment = {}
                commentData = comment
            } else {
                commentData = this.comment
            }

            console.log('commentData: ')
            console.log(commentData)

            axios.post(route('client.posts.comments.store', this.postData.id), commentData)
                .then(res => {
                    this.comment = {}
                    this.getComments()
                })
                .catch(e => {
                    console.log(e)
                })
        },
        toggleCommentLike(comment)
        {
            console.log('toggleCommentLike')

            axios.post(route('client.posts.comments.like.toggle', [ this.postData.id, comment.id ]))
                .then(res => {
                    console.log('res')
                    console.log(res)

                    this.commentsData.data.forEach((comment) => {
                        //console.log('comment')
                        //console.log(comment)
                        //console.log('res.data')
                        //console.log(res.data)

                        if (comment.id == res.data.id) {
                            comment.is_liked = res.data.is_liked; // Переключить значение is_liked
                            comment.liked_by_profiles_count = res.data.liked_by_profiles_count
                        }

                        // перебор по дочерним
                        if (comment.answers && comment.answers.length >= 1) {
                            //onsole.log('comment.answers')
                            //console.log(comment.answers)
                            comment.answers.forEach(answer => {
                                if (answer.id == res.data.id) {
                                    answer.is_liked = res.data.is_liked; // Переключить значение is_liked
                                    answer.liked_by_profiles_count = res.data.liked_by_profiles_count
                                }
                            })
                        }
                    });
                })
                .catch(e => {
                    console.log(e)
                })

        },
        changePage(link)
        {
            if (isNaN(link.label)) {
                let arr = link.url.split('page=')
                if (arr[1]) {
                    this.commentsPagination.page = arr[1]
                }
            } else {
                this.commentsPagination.page = link.label
            }

            this.getComments(); // Загружаем посты с новыми параметрами фильтра
        },
        getComments()
        {
            axios.get(route('client.posts.comments.index', this.postData.id), {
                params: this.commentsPagination
            })
                .then(res => {
                    this.commentsData = res.data

                    console.log(this.commentsData)
                })
                .catch(e => {
                    console.log(e)
                })
        },
        addAnswer(commentId)
        {
            console.log('addAnswer')
            /*console.log('answer:')
            console.log(answer)
            console.log('commentItem:')
            console.log(commentItem)*/

            this.commentsData.data.forEach(comment => {
                if (comment.id == commentId) {
                    comment.addAnswer = true
                } else {
                    comment.addAnswer = false
                }
            })
        },
        deleteComment(commentId, type)
        {
            console.log('deleteComment')
            console.log(commentId)
            console.log(type)



            axios.delete(route('client.posts.comments.destroy', {
                post: this.postData.id,
                comment: commentId
            }))
                .then(res => {
                    console.log(res)

                    if (type == 'comment') {
                        this.commentsData.data = this.commentsData.data.filter(comment => comment.id !== commentId)
                    } else {
                        this.commentsData.data.forEach((comment) => {
                            comment.answers = comment.answers.filter(answer => answer.id !== commentId);
                        });
                    }
                })
                .catch(e => {
                    console.log(e)
                })
        }
    },
    components: {
        CommentItem,
        Link
    },
    layout: ClientLayout
}
</script>
