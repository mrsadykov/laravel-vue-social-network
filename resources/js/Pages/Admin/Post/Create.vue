<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: 'Create',
    props: {
        categories: Array
        //tags: Array
    },
    data() {
        return {
            entries: {
                post: {
                    category_id: null,
                    //tag_id: null
                },
                tags: '',
                images: []
            },
            errors: {},
            is_success: false
        }
    },
    methods: {
        storePost() {
            // this.$refs - зарезервированный объект
            //console.log(this.$refs.image_input);

            console.log(this.entries)

            axios.post(route('admin.posts.store'), this.entries, {
                headers: {
                    "Content-Type": "multipart/form-data"
                }
            })
                .then( res => {
                    console.log(res)

                    this.entries.post = {
                        category_id: null
                    }

                    this.entries.images = {}

                    this.entries.tags = ''

                    this.$refs.image_input.value = null

                    // проблема:
                    // при обнулении срабатывает watch
                    // и плашка об успешном сохранении не показывается
                    //
                    // решение:
                    // используется механизм nextTick
                    // nextTick - это метод
                    // который позволяет отложить выполнение кода до следующего цикла обновления DOM.
                    // сначала все обнуляется и уже потом устанавливается this.is_success = true
                    this.$nextTick(function () {
                        this.is_success = true
                    })
                })
                .catch(e => {
                    this.errors = e.response.data.errors;
                    console.log(this.errors);
                })
        },

        setImages(e) {
            //this.entries.post.image = e.target.files[0]
            this.entries.images = e.target.files;
        }
    },
    // для слежения за изменениями свойств
    watch: {
        entries: {
            handler: function (newValue) {
                this.is_success = false
                this.errors = {}
            },
            deep: true
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
            Создание статьи
        </div>

        <div class="mb-4 pb-4 border-b border-gray-200">
            <div v-if="is_success" class="w-1/2 p-4 mb-4 bg-green-700 text-white">
                Статья добавлена
            </div>

            <div class="mb-4">
                <input
                    v-model="entries.post.title"
                    type="text"
                    placeholder="заголовок"
                    class="w-1/2 border border-gray-200 p-4">

                <div v-if="errors['post.title']">
                    <p class="text-red-500" v-for="error in errors['post.title']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <textarea
                    v-model="entries.post.content"
                    type="text"
                    placeholder="контент"
                    class="w-1/2 border border-gray-200 p-4"></textarea>

                <div v-if="errors['post.content']">
                    <p class="text-red-500" v-for="error in errors['post.content']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <input
                    v-model="entries.post.published_at"
                    type="date"
                    placeholder="published_at"
                    class="w-1/2 border border-gray-200 p-4">

                <div v-if="errors['post.published_at']" class="mb-4">
                    <p class="text-red-500" v-for="error in errors['post.published_at']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <select
                    v-model="entries.post.category_id"
                    class="w-1/2 border border-gray-200 p-4">
                    <option value="null" disabled>Выберите категорию</option>
                    <option v-for="category in categories" :value="category.id">
                        {{ category.title }}
                    </option>
                </select>

                <div v-if="errors['post.category_id']" class="mb-4">
                    <p class="text-red-500" v-for="error in errors['post.category_id']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                <input
                    v-model="entries.tags"
                    type="text"
                    placeholder="теги"
                    class="w-1/2 border border-gray-200 p-4">

                <div v-if="errors['tags']" class="mb-4">
                    <p class="text-red-500" v-for="error in errors['tags']">
                        {{ error }}
                    </p>
                </div>
            </div>

<!--            <div class="mb-4">-->
<!--                <select multiple v-model="entries.post.tags" class="w-1/2 border border-gray-200 p-4">-->
<!--                    <option v-for="tag in tags" :value="tag.id">-->
<!--                        {{ tag.title }}-->
<!--                    </option>-->
<!--                </select>-->
<!--            </div>-->

            <div class="mb-4">
                <!-- ref - это ссылка на тег (тег c ref image_input становится свойством глобального объекта $refs) -->
                <input
                    multiple
                    ref="image_input"
                    @change="setImages"
                    type="file"
                    placeholder="file">
            </div>

            <div class="mb-4">
                <a @click.prevent="storePost" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                    Добавить
                </a>
            </div>
        </div>

        <Link class="text-blue-500" :href="route('admin.posts.index')">Вернуться в список</Link>
    </div>
</template>
