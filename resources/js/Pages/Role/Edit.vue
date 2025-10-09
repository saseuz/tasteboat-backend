<script setup>
import config from '@/helpers/config'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { useForm } from '@inertiajs/vue3'
import Form from './Shared/Form.vue'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue'

let props = defineProps({
    role: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'Role', url: route(config.admin_route_name + 'roles.index') },
        { label: 'Edit' },
    ],
});

</script>

<template>
    <Head title="Role Edit" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Role Edit</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <Form routeName="roles.update" :isEdit="true" :role="props.role"/>
    </div>
</template>