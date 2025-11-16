<script>
import { Link } from "@inertiajs/vue3";

export default {
    name: 'Show',
    props: {
        chat: Object,
        login: String
    },
    components: {
        Link
    }
}
</script>

<template>
    <div class="mx-auto w-3/4 pt-4">
        <div class="mb-4">
            show chat
        </div>

        <div class="mb-4">
            {{ chat.title }}
        </div>

        <div class="mb-4">
            Author login: {{ login }}
        </div>

        <Link class="text-blue-500" :href="route('admin.chats.index')">Вернуться в список</Link>
    </div>
</template>

