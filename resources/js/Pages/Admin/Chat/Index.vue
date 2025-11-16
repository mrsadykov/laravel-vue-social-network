<script>
import {Link, router} from "@inertiajs/vue3";

export default {
    name: 'Index',
    props: {
        chats: Array
    },
    components: {
        Link
    }
}
</script>

<template>
  <div class="mx-auto w-3/4 pt-4">
      <div class="mb-4">
          chats index
      </div>

      <div>
          <div v-for="chat in chats" class="mb-4 pb-4 border-b border-gray-200">
            <Link :href="route('admin.chats.show', chat.id)">{{ chat.title }}</Link>
          </div>
      </div>
  </div>
</template>
