<script>
import {Link} from "@inertiajs/vue3";
import axios from "axios";

export default {
    name: "ClientLayout",
    components: {
        Link
    },
    data() {
        return {
            showNotifyNav: false,
            notificationsData: {}, //this.$page.props.auth.user.profile.notifications,
            notificationsPage: 1,
            showMoreBtn: true,
            notificationsCount: this.$page.props.auth.user.profile.notifications.length,
        }
    },
    mounted() {
        console.log('mointed')

        Echo.private(`notifications.${this.$page.props.auth.user.profile.id}`)
            .listen('.comment.stored', (res) => {
                this.notificationsCount++
            });
    },
    methods: {
        getNotifications()
        {
            axios.get(route('client.profiles.notifications.index'), {
                params: {
                    page: 1
                }
            })
                .then(res => {
                    console.log('res')
                    console.log(res)

                    if (this.notificationsData.data) {
                        this.notificationsData.data.forEach(notification => {
                            notification.is_read = true
                        })
                    }

                    if (this.notificationsPage > 1) {
                        this.notificationsData.data.push(...res.data.data)
                        this.notificationsData.meta = res.data.meta
                    } else {
                        this.notificationsData = res.data
                    }

                    this.notificationsCount -= res.data.data.length
                    if (this.notificationsCount < 0) this.notificationsCount = 0

                    this.showMoreBtn = this.notificationsData.meta.current_page < this.notificationsData.meta.last_page
                        ? true : false

                    this.showNotifyNav = this.notificationsData.data.length > 0
                        ? true : false
                })
                .catch(e => {
                    console.log(e)
                });
        },

        changePage()
        {
            this.notificationsPage++
            this.getNotifications()
        },

        hideNotifications()
        {
            this.showNotifyNav = false
        }
    },
}
</script>

<template>
    <div>
        <section>
            <header class="w-full p-4 bg-white flex items-center justify-between">
                <div>
                    Header
                </div>

                <div class="notify-section" v-click-outside="hideNotifications">
                    <div @click="getNotifications" class="cursor-pointer">
                        <div class="flex justify-between items-center">
                            <div class="mr-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24">
                                    <path fill="none" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"/>
                                </svg>
                            </div>

                            <div>
                                {{ notificationsCount }}
                            </div>
                        </div>
                    </div>

                    <div v-if="showNotifyNav" class="notify-nav">
                        <div class="mb-2 p-2 border-b border-gray-200" v-for="notification in notificationsData.data">
                            {{ notification.content }}

                            <span class="size-2 text-gray-400" v-if="notification.is_read">
                                прочитано
                            </span>
                        </div>

                        <div v-if="showMoreBtn" @click="changePage" class="border-sky-700 bg-sky-600 text-white inline-block px-2 py-1 border mr-2 cursor-pointer">
                            Show more
                        </div>
                    </div>
                </div>
            </header>
        </section>

        <section>
            <article class="w-full min-h-screen flex bg-gray-100 p-4">
                <div class="w-1/4 mr-4 bg-white">
                    <div class="m-4">
                        <Link :href="route('client.chats.index')">My chats</Link>
                    </div>

                    <div class="m-4">
                        <Link :href="route('client.profiles.index')">Profiles</Link>
                    </div>

                    <div class="m-4">
                        <Link :href="route('dashboard')">Dashboard</Link>
                    </div>

                    <div class="m-4">
                        <Link :href="route('client.notifications.index')">Notifications</Link>
                    </div>
                </div>

                <div class="w-3/4">
                    <slot />
                </div>
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
    .notify-section {
        position: relative;
    }

    .notify-nav {
        position: absolute;
        top: 100%;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        width: 300px;
        padding: 20px;
    }
</style>
