<script>
import {Link} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";

export default {
    name: 'Show',
    props: {
        category: Object
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
            {{ category.title }}
        </div>

        <Link class="text-blue-500" :href="route('admin.categories.index')">Вернуться в список</Link>
    </div>
</template>

<style scoped>

</style>
