<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: 'Index',
    props: {
        messages: Array
    },
    components: {
        Link
    }
}
</script>

<template>
    <div class="mx-auto w-3/4 pt-4">
        <div class="mb-4">
            message index
        </div>

        <div>
            <div v-for="message in messages" class="mb-4 pb-4 border-b border-gray-200">
                <Link :href="route('admin.messages.show', message.id)">{{ message.content }}</Link>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
