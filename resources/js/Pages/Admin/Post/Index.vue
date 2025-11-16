<script>
import {Link, router} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: 'Index',
    props: {
        posts: Object
    },
    data() {
        return {
            filter: {
                page: 1,
                title: '',
                published_at_from: '',
                content: '',
                views_from: '',
                category_title: ''
            },
            //posts: this.posts
            postsData: this.posts
        }
    },
    methods: {
        getPosts()
        {
            /*if (!this.filter.page) {
                this.filter.page = 1
            }*/

            axios.get(route('admin.posts.index'), {
                params: this.filter
            })
                .then(res => {
                    //this.posts = res.data
                    this.postsData = res.data
                    console.log(this.postsData)

                    if (this.postsData.meta.current_page > this.postsData.meta.last_page) {
                        this.filter.page = 1
                        //this.getPosts()
                    }
                })
                .catch(e => {
                    console.log(e)
                })
        },
        resetFilter()
        {
            this.filter = {
                page: 1,
                title: '',
                published_at_from: '',
                content: '',
                views_from: '',
                category_title: ''
            }

            this.getPosts()
        },
        deletePost(post)
        {
            axios.delete(route('admin.posts.destroy', post.id))
                .then(res => {
                    this.postsData = this.postsData.filter(postData =>
                        // возвращаем все посты кроме текущего
                        postData !== post
                    )
                })
        },
        toggleLike(post)
        {
            axios.post(route('admin.posts.like.toggle', post.id))
                .then(res => {
                    this.postsData.forEach((postData, index, array) => {
                        if (postData.id == post.id) {
                            array[index] = res.data
                        }
                    })
                })
                .catch(e => {
                    console.log(e)
                })
        },
        changePage(link) {
            if (isNaN(link.label)) {
                let arr = link.url.split('page=')
                if (arr[1]) {
                    this.filter.page = arr[1]
                }
            } else {
                this.filter.page = link.label
            }

            //console.log(this.filter)

            this.getPosts(); // Загружаем посты с новыми параметрами фильтра
        }
    },
    watch: {
        filter: {
            handler(newValue, oldValue) {
                //if (newValue !== oldValue) {
                    //this.filter.page = 1; // Сбрасываем страницу на 1 при любом изменении фильтра
                    this.getPosts();
                //}
            },
            deep: true
        }
    },
    mounted() {
        this.getPosts()
    },
    components: {
        Link
    },
    layout: AdminLayout
}
</script>

<template>
    <div class="mb-4">
        Статьи
    </div>

    <div class="mb-4">
        <Link class="inline-block px-3 py-2 bg-indigo-600 text-white border border-indigo-700" :href="route('admin.posts.create')">Добавить статью</Link>
    </div>

    <div class="mb-4 flex justify-between">
        <div>
            <input
                v-model="filter.title"
                type="text"
                name="title"
                class="border border-gray-200 p-4"
                placeholder="Заголовок">
        </div>

        <div>
            <input
                type="date"
                v-model="filter.published_at_from"
                name="published_at_from"
                placeholder="Публикации от"
                class="border border-gray-200 p-4">
        </div>

        <div>
            <input
                v-model="filter.content"
                type="text"
                name="content"
                class="border border-gray-200 p-4"
                placeholder="Контент">
        </div>

        <div>
            <input
                v-model="filter.views_from"
                type="number"
                name="views_from"
                placeholder="Просмотров от"
                class="border border-gray-200 p-4">
        </div>

        <div>
            <input
                type="text"
                v-model="filter.category_title"
                name="category_title"
                placeholder="Категория"
                class="border border-gray-200 p-4">
        </div>
    </div>

    <div class="mb-4">
        <a @click.prevent="resetFilter" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
            Сбросить фильтр
        </a>
    </div>

    <div class="mb-4">
        <table class="border-collapse border border-gray-200 table-auto w-full text-sm">
            <thead class="bg-gray-100 dark:bg-slate-800">
            <tr>
                <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">ID</th>
                <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Заголовок</th>
                <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">Опции</th>
            </tr>
            </thead>
            <tbody class="bg-white dark:bg-slate-800">
            <tr v-for="post in postsData.data" class="border-b border-gray-200">
                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                    {{ post.id }}
                </td>
                <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                    <Link :href="route('admin.posts.show', post.id)">
                        {{ post.title }}
                    </Link>
                </td>
                <td class="flex justify-around text-center dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                    <Link :href="route('admin.posts.edit', post.id)">
                        Редактировать
                    </Link>

                    <a @click.prevent="deletePost(post)">
                        Удалить
                    </a>

                    <div class="flex items-center align-middle justify-center">
                        <div class="mr-1">
                            {{ post.liked_by_profiles_count }}
                        </div>

                        <div>
                            <svg @click="toggleLike(post)" class="cursor-pointer" style="width:20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" width="512" height="512" viewBox="0 0 36 36">
                                <path :fill="post.is_liked ? '#DD2E44' : '#000000'" d="M35.885 11.833c0-5.45-4.418-9.868-9.867-9.868c-3.308 0-6.227 1.633-8.018 4.129c-1.791-2.496-4.71-4.129-8.017-4.129c-5.45 0-9.868 4.417-9.868 9.868c0 .772.098 1.52.266 2.241C1.751 22.587 11.216 31.568 18 34.034c6.783-2.466 16.249-11.447 17.617-19.959c.17-.721.268-1.469.268-2.242z"/>
                            </svg>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- <div v-else>
        <p>
            Статей нет
        </p>
    </div> -->

    <div class="mb-4" v-if="postsData.meta.links.length > 3">
        <template v-for="link in postsData.meta.links">
            <div
                @click.prevent="changePage(link)"
                :class="[ link.active ? 'border-sky-700 bg-sky-600 text-white' : 'border-gray-200 bg-white text-gray-600', 'inline-block px-2 py-1 border mr-2 cursor-pointer']"
                v-html="link.label"
                v-if="link.url !== null">
            </div>
        </template>
    </div>
</template>
