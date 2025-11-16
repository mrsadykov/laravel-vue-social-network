<template>
    <div class="text-gray-600 mb-4 p-4 border border-gray-200">
        <div class="mb-4">
            <p class="text-sm">{{ commentItem.content }}</p>
        </div>

        <div class="flex justify-between">
            <p class="text-xs mr-2">{{ commentItem.profile.login }}</p>

            <div class="flex">
                <a @click.prevent="handleAddAnswer" class="text-xs block cursor-pointer mr-2">
                    Ответить
                </a>

                <a v-if="this.$page.props.auth.user.profile.id == commentItem.profile.id"
                    @click.prevent="handleDeleteCommentAnswer(commentItem.id, 'comment')"
                    class="text-xs block cursor-pointer mr-2">
                    Удалить
                </a>

                <div class="text-xs flex justify-between">
                    <p class="text-xs mr-4">{{ commentItem.formatted_date }}</p>

                    <div class="mr-2">
                        {{ commentItem.liked_by_profiles_count }}
                    </div>

                    <LikeItem :commentItem="commentItem"
                        @toggle-comment-like="(comment) => handleToggleLike(comment)"></LikeItem>
                </div>
            </div>
        </div>

        <div v-if="commentItem.answers.length >= 1">
            <div class="border border-gray-200 m-4 p-4" v-for="answer in commentItem.answers">
                <div class="mb-4">
                    <p class="text-sm">{{ answer.content }}</p>
                </div>

                <div class="flex justify-between">
                    <p class="text-xs mr-2">{{ answer.profile.login }}</p>

                    <div class="flex">
                        <p class="text-xs mr-4">{{ answer.formatted_date }}</p>

                        <a v-if="this.$page.props.auth.user.profile.id == answer.profile.id"
                            @click.prevent="handleDeleteCommentAnswer(answer.id, 'answer')"
                            class="text-xs block cursor-pointer mr-2">
                            Удалить
                        </a>

                        <div class="text-xs flex justify-between">
                            <div class="mr-1">
                                {{ answer.liked_by_profiles_count }}
                            </div>

                            <LikeItem :commentItem="answer"
                                @toggle-comment-like="(comment) => handleToggleLike(comment)"></LikeItem>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="commentItem.addAnswer" class="border border-gray-200 m-4 p-4">
            <div>
                <textarea class="border border-gray-200 w-full" v-model="comment.content" placeholder="Комментарий"></textarea>
            </div>

            <div>
                <a
                    @click.prevent="handleDeleteCommentAnswer(commentItem.id)"
                    class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                    Удалить
                </a>
            </div>

            <div>
                <a @click.prevent="storeCommentAnswer(commentItem.id)" class="inline-block px-3 py-2 bg-emerald-600 border border-emerald-700 text-white">
                    Ответить
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import LikeItem from '../Like/LikeItem.vue'

export default {
    name: "CommentItem",
    props: {
        commentItem: Object
    },
    data() {
        return {
            comment: {}
        }
    },
    methods: {
        handleAddAnswer()
        {
            this.$emit('add-answer', this.commentItem.id)
        },
        storeCommentAnswer(commentId)
        {
            this.comment.parent_comment_id = commentId
            this.$emit('store-comment', this.comment)
            this.comment = {}
        },
        handleToggleLike(comment)
        {
            this.$emit('toggle-comment-like', comment)
        },
        handleDeleteCommentAnswer(commentId, type)
        {
            this.$emit('delete-comment', commentId, type);
        }
    },
    components: {
        LikeItem
    }
}
</script>
