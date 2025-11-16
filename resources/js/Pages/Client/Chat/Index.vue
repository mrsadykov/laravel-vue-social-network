<template>
    <div class="w-3/4 mb-4 flex items-center">
        <div>
            My chats
        </div>

        <div class="ml-4">
            <a @click.prevent="showProfilesSelect = true"
                class="inline-block px-3 py-2 text-white bg-sky-600 border border-sky-600">
                +
            </a>
        </div>
    </div>

    <div class="w-1/4 mb-4" v-if="showProfilesSelect">
        <div class="mb-2">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Select profiles for group chat
            </label>
        </div>

        <div class="mb-2">
            <select multiple
                v-model="entries.profile_ids"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option v-for="profile in profiles" :value="profile.id">
                    [ {{ profile.login }} ] {{ profile.name }}
                </option>
            </select>
        </div>

        <div class="mb-2">
            <Link :href="route('client.chats.store')"
                method="post"
                :data="entries"
                class="inline-block px-3 py-2 text-white bg-sky-600 border border-sky-600">
                Create group chat
            </Link>
        </div>
    </div>

    <div v-for="chat in chats" class="mb-4">
        <Link :href="route('client.chats.show', chat.id)" class="text-blue-500" >
            {{ chat.title }}
        </Link>
    </div>
</template>

<script>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

export default {
    name: "Show",
    props: {
        chats: Array,
        profiles: Array
    },
    data() {
        return {
            showProfilesSelect: false,
            entries: {
                profile_ids: []
            }
        }
    },
    layout: ClientLayout,
    components: {
        Link
    }
}
</script>
