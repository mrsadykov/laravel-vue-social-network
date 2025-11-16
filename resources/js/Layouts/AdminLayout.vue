<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "AdminLayout",
    components: {
        Link
    }
}
</script>

<template>
    <div>
        <section>
            <header class="w-full py-4 bg-white">
                Header
            </header>
        </section>

        <section class="flex">
            <aside class="min-h-screen w-1/4 bg-gray-700 h-full">
                <Link :href="route('admin.posts.index')" class="block text-gray-400 p-4 border-b border-gray-500">Статьи</Link>
                <Link :href="route('admin.categories.index')" class="block text-gray-400 p-4 border-b border-gray-500">Категории</Link>
                <Link :href="route('admin.tags.index')" class="block text-gray-400 p-4 border-b border-gray-500">Теги</Link>
                <Link :href="route('admin.stats.index')" class="block text-gray-400 p-4 border-b border-gray-500">Статистика</Link>
            </aside>
            <article class="w-3/4 bg-gray-100 p-4">
                <slot />
            </article>
        </section>

        <section>
            <footer class="w-full py-4 bg-white">
                Footer
            </footer>
        </section>
    </div>
</template>

<style scoped>

</style>
