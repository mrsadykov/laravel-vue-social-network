<script>
import ClientLayout from '@/Layouts/ClientLayout.vue';

export default {
    name: "Index",
    props: {
        notifications: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            notificationsData: this.notifications,
        }
    },
    methods: {
        updatePosts()
        {
            console.log('updatePosts')
            console.log(this.notificationsData)

            axios.post(route('client.notifications.update.markAllAsRead'), {
                _method: 'PATCH'
            })
                .then(res => {
                    console.log(res)

                    this.notificationsData = res.data
                })
                .catch(e => {
                    console.log(e)
                })
        }
    },
    mounted() {
        console.log(this.notificationsData)
    },
    layout: ClientLayout
}
</script>

<template>
    <div class="w-full bg-white">
        <div>
            <a @click.prevent="updatePosts"
                class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white cursor-pointer">
                Read all
            </a>
        </div>

        <div>
            <table class="border-collapse border border-gray-200 table-auto w-full text-sm">
                <thead class="bg-gray-100 dark:bg-slate-800">
                <tr>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Created at
                    </th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Content
                    </th>
                    <th class="text-center border-b dark:border-slate-600 font-medium p-4 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Read
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                <tr v-for="notification in notificationsData.data" class="border-b border-gray-200">
                    <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        {{ notification.created_at }}
                    </td>

                    <td class="text-center border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        {{ notification.content }}
                    </td>

                    <td class="flex justify-around text-center dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        <svg v-if="notification.read_at" xmlns="http://www.w3.org/2000/svg" width="200" height="200" class="size-5" viewBox="0 0 20 20">
                            <path fill="#000000" fill-rule="evenodd" d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Zm10.857 5.691a.75.75 0 0 0-1.214-.882l-3.483 4.79l-1.88-1.88a.75.75 0 0 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                        </svg>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
