<script setup>
import config from '@/helpers/config'
import { useForm } from '@inertiajs/vue3'
import Form from './Shared/Form.vue'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue'

let props = defineProps({
    ingredient: Object,
    recipes: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'Ingredient', url: route(config.admin_route_name + 'ingredients.index') },
        { label: 'Edit' },
    ],
});

</script>

<template>
    <Head title="Ingredient Edit" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Ingredient Edit</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <Form 
            routeName="ingredients.update" 
            :isEdit="true" 
            :ingredient="props.ingredient" 
            :recipes="props.recipes"
            v-if="$can('update-ingredient')"
        />
        <div class="mb-4" v-else>
            You don't have permission to edit.
        </div>
    </div>
</template>