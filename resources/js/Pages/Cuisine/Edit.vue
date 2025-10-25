<script setup>
import config from '@/helpers/config'
import { useForm } from '@inertiajs/vue3'
import Form from './Shared/Form.vue'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue'

let props = defineProps({
    cuisine: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'Cuisine', url: route(config.admin_route_name + 'cuisines.index') },
        { label: 'Edit' },
    ],
});

</script>

<template>
    <Head title="Cuisine Edit" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Cuisine Edit</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <Form routeName="cuisines.update" :isEdit="true" :cuisine="props.cuisine" v-if="$can('update-cuisine')"/>
        <div class="mb-4" v-else>
            You don't have permission to edit.
        </div>
    </div>
</template>