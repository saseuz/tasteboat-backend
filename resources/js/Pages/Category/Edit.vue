<script setup>
import config from '@/helpers/config'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { useForm } from '@inertiajs/vue3'
import Form from './Shared/Form.vue'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue'

let props = defineProps({
    category: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'Category', url: route(config.admin_route_name + 'categories.index') },
        { label: 'Edit' },
    ],
});

</script>

<template>
    <Head title="Category Edit" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Category Edit</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <Form routeName="categories.update" :isEdit="true" :category="props.category" v-if="$can('update-category')"/>
        <div class="mb-4" v-else>
            You don't have permission to edit.
        </div>
    </div>
</template>