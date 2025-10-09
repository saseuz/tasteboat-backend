<script setup>
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table'
import config from '@/helpers/config'
import { Plus } from 'lucide-vue-next';
import { useForm } from '@inertiajs/vue3';
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';
import DeleteDialog from '@/Shared/DeleteDialog.vue';

let props = defineProps({
    roles: Object,
});

let form = useForm({
    deleteDialog: {
        title: 'Are you absolutely sure?',
        message: 'This action cannot be undone. This will permanently delete the role.'
    },
    breadscrumbs: [
        { label: 'Role' },
    ],
});
</script>

<template>
    <Head title="Role Management" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Role Management</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="flex justify-end mb-4">
            <Link 
                :href="route(config.admin_route_name + 'roles.create')"
                class="flex items-center gap-2 bg-[#2a3f5f] hover:bg-[#2a3f5f]/50 text-white font-semibold py-2 px-4 rounded shadow transition"
            >
                <Plus /> Create
            </Link>
        </div>
        <Table class="bg-[#243447] rounded">
            <TableCaption>A list of your recent roles.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]">
                    ID
                    </TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead class="text-right">
                    Action
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="role in roles.data" :key="role.id">
                    <TableCell class="font-medium">
                    {{ role.id}}
                    </TableCell>
                    <TableCell>{{ role.name  }}</TableCell>
                    <TableCell class="text-right space-x-2">
                        <Link
                            :href="route(config.admin_route_name + 'roles.show', role.id)"
                            class="text-blue-400 hover:underline"
                        >
                            Show
                        </Link>
                        <Link
                            :href="route(config.admin_route_name + 'roles.edit', role.id)"
                            class="text-blue-600 hover:underline"
                        >
                            Edit
                        </Link>
                        <DeleteDialog :data="form.deleteDialog" :route="route(config.admin_route_name + 'roles.destroy', role.id)" />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
    
</template>
