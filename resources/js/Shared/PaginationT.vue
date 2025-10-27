<script setup>

let props = defineProps({
    links: Array,
});

</script>

<template>
    <div v-if="props.links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <div class="bg-[#243447] flex justify-between rounded p-1">
                <template v-for="(link, key) in props.links">                    
                    <div v-if="link.url === null" :key="key" class="mr-1 px-3 py-2 text-gray-400 text-sm leading-4 border rounded" v-html="link.label" />
                    <Link v-else :key="`link-${key}`" class="mr-1 px-3 py-2 focus:text-indigo-500 text-sm leading-4 hover:bg-secondary border focus:border-indigo-500 rounded" :class="{ 'bg-secondary': link.active }" :href="link.url" v-html="link.label" />
                </template>
            </div>
        </div>
    </div>
</template>