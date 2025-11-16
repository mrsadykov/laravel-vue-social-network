<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: 'Index',
    props: {
        tags: Array
    },
    components: {
        Link
    },
    layout: AdminLayout
}
</script>

<template>
    <div class="mx-auto w-3/4 pt-4">
        <div class="mb-4">
            Список тегов
        </div>

        <div class="mb-4">
            <Link class="inline-block px-3 py-2 bg-indigo-600 text-white border border-indigo-700" :href="route('admin.tags.create')">Добавить тег</Link>
        </div>

        <div>
            <div v-for="tag in tags" class="mb-4 pb-4 border-b border-gray-200">
                <Link :href="route('admin.tags.show', tag.id)">{{ tag.title }}</Link>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
