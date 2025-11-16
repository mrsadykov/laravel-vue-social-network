<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: 'Show',
    props: {
        tag: Object
    },
    components: {
        Link
    }
}
</script>

<template>
    <div class="mx-auto w-3/4 pt-4">
        <div class="mb-4">
            {{ tag.title }}
        </div>

        <Link class="text-blue-500" :href="route('admin.tags.index')">Вернуться в список</Link>
    </div>
</template>

<style scoped>

</style>
