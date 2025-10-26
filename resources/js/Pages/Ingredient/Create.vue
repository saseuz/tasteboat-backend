<script setup>
import config from '@/helpers/config'
import Form from './Shared/Form.vue'
import { useForm } from '@inertiajs/vue3'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';

let props = defineProps({
    recipes: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'Ingredient', url: route(config.admin_route_name + 'ingredients.index') },
        { label: 'Create' },
    ],
});

</script>

<template>
    <Head title="Ingredient Create" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Ingredient Create</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <Form routeName="ingredients.store" :recipes="props.recipes" v-if="$can('create-ingredient')" />
        <div class="my-4" v-else>
            You don't have permission to create.
        </div>
    </div>
</template>