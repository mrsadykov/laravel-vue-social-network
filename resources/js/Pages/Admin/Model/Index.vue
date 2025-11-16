<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: 'Index',
    props: {
        models: Array
    },
    components: {
        Link
    }
}
</script>

<template>
    <div class="mx-auto w-3/4 pt-4">
        <div class="mb-4">Бизнес сущности</div>

        <div>
            <div v-for="model in models" class="mb-4 pb-4 border-b border-gray-200">
                <Link :href="route(model.routeName, model.id)">{{ model.title }}</Link>
            </div>
        </div>
    </div>
</template>
