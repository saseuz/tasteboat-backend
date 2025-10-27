<script setup>
import CommentItem from './CommentItem.vue';

defineProps({
    comment: Object
})
</script>

<template>
    <div class="flex flex-col m-2 p-2 border border-slate-400 rounded">

        <div class="flex justify-between text-xs font-medium">
            <div>By: {{ comment.user?.name || 'Unknow' }}</div>
            <div>At: {{ comment.created_at }}</div>
        </div>
        <p class="pl-2">{{ comment.content }}</p>

        <div v-if="comment.replies && comment.replies.length > 0">
            <CommentItem 
                v-for="(reply, index) in comment.replies"
                :key="index"
                :comment="reply"
            />
        </div>

    </div>
</template>
