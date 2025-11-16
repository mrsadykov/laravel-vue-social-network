<template>
    <div>
        <a @click.prevent="toggleFollowing"
            :key="profile.id"
            :class="[ profile.is_followed
                ? 'bg-red-600 border-red-700'
                : 'bg-emerald-600 border-emerald-700',
                'cursor-pointer inline-block px-3 py-2 text-white border'
            ]"
            v-html="profile.is_followed ? 'Отписаться' : 'Подписаться'">
        </a>
    </div>
</template>

<script>
export default {
    name: "SubscribeButton.vue",
    props: {
        profile: {
            required: true,
            type: Object
        }
    },
    data() {
        return {
            profileData: this.profile
        }
    },
    methods: {
        toggleFollowing()
        {
            this.$emit('toggle-following', this.profile.id);
        }
    },
}
</script>
