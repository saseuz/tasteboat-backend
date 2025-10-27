<script setup>
import CommentItem from './CommentItem.vue'

defineProps({
    comments: Array
})
</script>

<template>
    <div>
        <CommentItem
            v-for="(comment, index) in comments"
            :key="index"
            :comment="comment"
        />
    </div>
</template>