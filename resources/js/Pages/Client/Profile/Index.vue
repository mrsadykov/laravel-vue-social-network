<template>
    <div class="w-1/2">
        <div v-for="profile in profiles"
            class="bg-white mb-4 p-4 flex justify-between items-center">

            <Link :href="route('client.profiles.show', profile.id)" class="hover:underline">
                {{ profile.login }}
            </Link>

            <SubscribeButton :profile="profile"
                @toggle-following="toggleFollowing"></SubscribeButton>
        </div>
    </div>
</template>

<script>
import SubscribeButton from '@/Components/Profile/SubscribeButton.vue';
import ClientLayout from '@/Layouts/ClientLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    name: "Index",
    props: {
        profiles: {
            required: true,
            type: Array
        }
    },
    data() {
        return {
            profilesData: this.profiles
        }
    },
    methods: {
        toggleFollowing(profileId)
        {
            axios.post(route('client.profiles.followings.toggle', profileId))
                .then(res => {
                    this.profilesData.forEach(profile => {
                        if (profile.id == profileId) {
                            profile.is_followed = res.data.is_followed
                        }
                    })
                })
                .catch(e => {
                    console.log(e)
                })
        }
    },
    components: {
        Link,
        SubscribeButton
    },
    mounted() {
        console.log(this.profiles)
    },
    layout: ClientLayout
}
</script>
