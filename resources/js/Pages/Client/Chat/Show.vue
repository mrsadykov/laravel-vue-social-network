<script>
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: "Show",
    props: {
        chat: {
            required: true,
            type: Object
        },
        messages: {
            required: false,
            type: Array
        },
        profiles: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            message: {},
            chatData: this.chat,
            messagesData: this.messages,
            echoListener: null
            //wsResponse: ''
        }
    },
    mounted() {
        // Echo.channel
        this.echoListener = Echo.private(`chats.${this.chatData.id}.stored_message`)
            .listen('.message.stored', (res) => {
                console.log(res)

                console.log('this.$page.props.auth.user.profile.id')
                console.log(this.$page.props.auth.user.profile.id)

                console.log('res.message.profile.id')
                console.log(res.message.profile.id)

                //if (this.$page.props.auth.user.profile.id !== res.message.profile.id) {
                    console.log('false')
                    res.message.is_owner = false
                //}

                this.messagesData.push(res.message)
            });
    },
    beforeUnmount() {
        // Важно: очищаем подписку при уничтожении компонента
        if (this.echoListener) {
            this.echoListener.stopListening('.message.stored');
            Echo.leaveChannel(`chats.${this.chatData.id}.stored_message`);
        }
    },
    methods: {
        storeMessage()
        {
            axios.post(route('client.chats.messages.store', this.chatData.id), this.message)
                .then(res => {
                    this.messagesData.push(res.data)
                    this.message = {}
                })
                .catch(e => {
                    console.log(e)
                })
        },
        /*getMessages()
        {
            axios.get(route('client.chats.messages.get', this.chatData.id))
                .then(res => {
                    this.messagesData = res.data
                    this.message = {}
                })
                .catch(e => {
                    console.log(e)
                });
        }*/
    },
    layout: ClientLayout,
    components: {
        Link
    }
}
</script>

<template>
    <div>
        <div>
            {{ chat.title }}
        </div>

        <div>
            <div class="flex">
                <!-- Сообщение -->
                <div class="h-auto w-3/4">
                    <div v-for="messageItem in messagesData"
                        :class="[
                            messageItem.is_owner
                            ? 'justify-end'
                            : 'justify-start',
                            'flex'
                        ]">
                        <div :class="[
                            messageItem.is_owner
                                ? 'bg-emerald-100 border-emerald-200 text-right'
                                : 'bg-white border-gray-200 text-left',
                            'mb-4 p-4 border'
                        ]">
                            <p class="mb-2 text-sm text-gray-600">{{ messageItem.profile.login }}</p>
                            <p class="mb-2 text-gray-800">{{ messageItem.content }}</p>
                            <p class="text-sm text-gray-400">{{ messageItem.formatted_date }}</p>
                        </div>
                    </div>

                    <!-- Участники -->
                    <div class="mb-4">
                        <textarea placeholder="message"
                            v-model="message.content"
                            @keyup.enter.ctrl="storeMessage"
                            class="w-full border border-gray-200 p-4"></textarea>
                    </div>

                    <div class="mb-4">
                        <a @click.prevent="storeMessage" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                            Добавить
                        </a>
                    </div>
                </div>

                <div class="h-auto w-1/4">
                    <div class="p-4 m-4" v-for="profile in profiles">
                        <div class="mb-2">
                            <Link :href="route('client.profiles.show', profile.id)"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                {{ profile.login }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
