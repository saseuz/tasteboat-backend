<script setup>
import config from '@/helpers/config';


</script>

<template>
    <footer class="flex bg-secondary text-white justify-center items-center h-12">
        <p class="text-sm font-bold">&copy; {{ new Date().getFullYear() }} {{ config.app_name  }}. All rights reserved.</p>
    </footer>
</template>