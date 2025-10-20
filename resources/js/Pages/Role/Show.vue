<script setup>
import config from '@/helpers/config'

import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';

let props = defineProps({
    role: Object,
    permissions: Array,
    groups: Array,
});

let form = useForm({
    permissions: props.permissions ? props.permissions : [],
    breadscrumbs: [
        { label: 'Role', url: route(config.admin_route_name + 'roles.index') },
        { label: 'Details' },
    ],
});

const toggleGroup = (group) => {
    const groupPermissionIds = group.permissions.map(p => p.id);
    const allSelected = groupPermissionIds.every(id => form.permissions.includes(id));

    if (allSelected) {
        form.permissions = form.permissions.filter(id => !groupPermissionIds.includes(id));
    } else {
        form.permissions = [...form.permissions, ...groupPermissionIds];
    }
}

const togglePermission = (id) => {
  if (form.permissions.includes(id)) {
    form.permissions = form.permissions.filter(p => p !== id)
  } else {
    form.permissions.push(id)
  }
}

const submit = () => {
    form.post(route(config.admin_route_name + 'roles.permissions.update', props.role.id), {
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>

<template>
    <Head title="Role Details" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Role Details</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="w-full max-w-full bg-gray-800 rounded shadow p-4" v-if="$can('assign-permissions')">
            <h2 class="text-lg">Role Name: {{ role.name }}</h2>

            <div class="mt-4">
                <h3 class="text-md mb-4">Permissions</h3>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div v-for="group in groups" :key="group.id" class="border p-4 rounded bg-gray-900">
                            <h4 class="font-semibold mb-2" @click="toggleGroup(group)">{{ group.name }}</h4>
                            <ul class="list-none list-inside">
                                <li v-for="permission in group.permissions" :key="permission.id">
                                    <input 
                                        type="checkbox" 
                                        :id="permission.id.toString()" 
                                        class="bg-white mr-1" 
                                        :checked="form.permissions.includes(permission.id)" 
                                        @change="togglePermission(permission.id)"
                                    />
                                    <label :for="permission.id.toString()"
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                    >
                                        {{ permission.name }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                
                    <div class="flex gap-3 mt-8">
                        <Button type="submit" class="bg-slate-700 hover:bg-slate-700/50 text-white transition font-semibold shadow-xl" :disabled="form.processing">
                        Submit
                        </Button>
                        <Button asChild variant="outline" class="text-white bg-transparent">
                            <Link :href="route(config.admin_route_name + 'roles.index')">Cancel</Link>
                        </Button>
                    </div>
                </form>
            </div>
        </div>
        <div class="mb-4" v-else>
            You don't have permission to view detail.
        </div>
    </div>
    
</template>