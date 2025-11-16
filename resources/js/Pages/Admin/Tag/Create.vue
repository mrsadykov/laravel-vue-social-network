<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: "Create",
    data() {
        return {
            tag: {}
        }
    },
    methods: {
        storeTag() {
            axios.post(route('admin.tags.store'), this.tag)
                .then(res => {
                    console.log(res)
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
            Создание тега
        </div>

        <div class="mb-4 pb-4 border-b border-gray-200 ">
            <div class="mb-4">
                <input v-model="tag.title" type="text" placeholder="название категории" class="w-1/2 border border-gray-200 p-4">
            </div>

            <div class="mb-4">
                <a @click.prevent="storeTag" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                    Добавить
                </a>
            </div>
        </div>

        <Link class="text-blue-500" :href="route('admin.tags.index')">Вернуться в список</Link>
    </div>
</template>
