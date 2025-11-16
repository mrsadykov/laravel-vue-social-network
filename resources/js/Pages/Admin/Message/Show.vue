<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: 'Show',
    props: {
        message: Object,
        chatTitle: String,
        profileLogin: String
    },
    components: {
        Link
    }
}
</script>

<template>
    <div class="mx-auto w-3/4 pt-4">
        <div class="mb-4">
            show
        </div>

        <div class="mb-4">
            Сообщение: {{ message.content }}
        </div>

        <div class="mb-4">
            Заголовок чата: {{ chatTitle }}
        </div>

        <div class="mb-4">
            Логин автора: {{ profileLogin }}
        </div>

        <Link class="text-blue-500" :href="route('admin.messages.index')">Вернуться в список</Link>
    </div>
</template>

<style scoped>

</style>
