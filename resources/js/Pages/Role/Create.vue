<script setup>
import config from '@/helpers/config'
import Form from './Shared/Form.vue'
import { useForm } from '@inertiajs/vue3'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';

let form = useForm({
    breadscrumbs: [
        { label: 'Role', url: route(config.admin_route_name + 'roles.index') },
        { label: 'Create' },
    ],
});

</script>

<template>
    <Head title="Role Create" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Role Create</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <Form routeName="roles.store" />
    </div>
</template>