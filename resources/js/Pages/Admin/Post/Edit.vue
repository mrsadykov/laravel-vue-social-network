<script>

import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Edit",
    props: {
        post: Object,
        categories: Array,
        tags: String
    },
    data() {
        return {
            entries: {
                post: {
                    id: this.post.id,
                    title: this.post.title,
                    content: this.post.content,
                    published_at: this.post.published_at, //'1996-02-15'
                    category_id: this.post.category_id,
                    images: this.post.images
                },
                tags: this.tags,
                // новые картинки
                images: [],
                // id удаленных картинок
                deletedImagesIds: [],
                _method: 'PATCH'
            },
            is_success: false,
            errors: {}
        }
    },
    methods: {
        updatePost()
        {
            console.log(this.entries)

            axios.post(
                route('admin.posts.update', this.entries.post.id),
                this.entries,
                {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                }
            )
                .then(res => {
                    console.log(res)

                    this.$refs.image_input.value = null
                    this.changeImages(res)

                    // nextTick - это метод
                    // который позволяет отложить выполнение кода до следующего цикла обновления DOM.
                    // сначала все обнуляется и уже потом устанавливается this.is_success = true
                    this.$nextTick(function () {
                        this.is_success = true
                    })
                })
                .catch(e => {
                    console.log(e)

                    this.errors = e.response.data.errors
                    console.log(this.errors);
                })
        },
        changeImages(res)
        {
            console.log('changeImages')
            console.log(res)
            console.log(res.data.images)
            this.entries.post.images = res.data.images
        },
        deleteImage(image)
        {
            // Добавляем ID в массив
            this.entries.deletedImagesIds.push(image.id);

            // Для отладки
            console.log("Current deleted IDs:", this.entries.deletedImagesIds);

            // Удаляем изображение из UI
            this.entries.post.images = this.entries.post.images.filter(
                img => img.id !== image.id
            );

            console.log(this.entries.deletedImagesIds)
        },
        setImages(e)
        {
            console.log('setImages')
            this.entries.images = e.target.files;
        }
    },
    // отслеживаем изменения данных
    watch: {
        entries: {
            handler: function (newValue) {
                // для скрытия плашки
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
            Редактирование статьи
        </div>

        <div v-if="is_success" class="w-1/2 p-4 mb-4 bg-green-700 text-white">
            Статья обновлена
        </div>

        <div class="mb-4 pb-4 border-b border-gray-200">
            <div class="mb-4">
                Заголовок
            </div>
            <div class="mb-4">
                <input type="text"
                   v-model="entries.post.title"
                   placeholder="Заголовок"
                   class="w-1/2 border border-gray-200 p-4" >

                <div v-if="errors['post.title']">
                    <p class="text-red-500" v-for="error in errors['post.title']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                Контент
            </div>
            <div class="mb-4">
                <input type="text" v-model="entries.post.content" placeholder="Контент" class="w-1/2 border border-gray-200 p-4">

                <div v-if="errors['post.content']">
                    <p class="text-red-500" v-for="error in errors['post.content']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                Дата публикации
            </div>
            <div class="mb-4">
                <input type="date" v-model="entries.post.published_at" placeholder="Дата публикации" class="w-1/2 border border-gray-200 p-4">

                <div v-if="errors['post.published_at']" class="mb-4">
                    <p class="text-red-500" v-for="error in errors['post.published_at']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                Категория
            </div>
            <div class="mb-4">
                <select v-model="entries.post.category_id"
                    class="w-1/2 border border-gray-200 p-4"
                    :value="entries.post.category_id">
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
                Теги
            </div>
            <div class="mb-4">
                <input v-model="entries.tags" type="text" placeholder="теги" class="w-1/2 border border-gray-200 p-4">

                <div v-if="errors['tags']" class="mb-4">
                    <p class="text-red-500" v-for="error in errors['tags']">
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="mb-4">
                Картинки
            </div>
            <div v-if="entries.post.images.length" class="grid grid-cols-3 gap-4 mb-6">
                <div v-for="image in entries.post.images" :key="image.id" class="relative group">
                    <img :src="image.url" :alt="entries.post.title" class="w-full h-48 object-cover rounded">
                    <button type="button"
                        @click="deleteImage(image)"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 opacity-0 group-hover:opacity-100 transition-opacity">
                        ×
                    </button>
                </div>
            </div>
            <div v-else class="mb-4 text-gray-500">
                Нет изображений
            </div>

            <!-- Кнопка загрузки -->
            <div class="mb-4">
                <!--
                    ref - зарезирвированный глобальный объект
                    image_input становится свойством глобального объекта $ref - this.$refs.image_input
                -->
                <input ref="image_input"
                    type="file"
                    multiple
                    @change="setImages"
                    placeholder="file">
            </div>

            <div class="mb-4">
                <a @click.prevent="updatePost" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                    Обновить
                </a>
            </div>
        </div>

        <Link class="text-blue-500" :href="route('admin.posts.index')">Вернуться в список</Link>
    </div>
</template>
