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
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';
import { useForm } from '@inertiajs/vue3';
import DeleteDialog from '@/Shared/DeleteDialog.vue';
import PaginationT from '@/Shared/PaginationT.vue';

let props = defineProps({
    admins: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'Admin' },
    ],
    deleteDialog: {
        title: 'Are you absolutely sure?',
        message: 'This action cannot be undone. This will permanently delete your account and remove your data from our servers.',
    }
});

</script>

<template>
    <Head title="Admin Management" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Admin Management</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="flex justify-end mb-4">
            <Link 
                v-if="$can('create-admin')"
                :href="route(config.admin_route_name + 'admins.create')"
                class="flex items-center gap-2 bg-[#2a3f5f] hover:bg-[#2a3f5f]/50 text-white font-semibold py-2 px-4 rounded shadow transition"
            >
                <Plus /> Create
            </Link>
        </div>
        <div v-if="$can('view-admin')">
            <Table class="bg-[#243447] rounded">
                <TableCaption>A list of your recent admins.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                        ID
                        </TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Roles</TableHead>
                        <TableHead class="text-right">
                        Action
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="admin in admins.data" :key="admin.id">
                        <TableCell class="font-medium">
                        {{ admin.id}}
                        </TableCell>
                        <TableCell>{{ admin.name  }}</TableCell>
                        <TableCell>{{ admin.email }}</TableCell>
                        <TableCell>
                            <span v-for="role in admin.roles" :key="role.id" class="inline-block bg-blue-200 text-blue-800 text-xs px-2 rounded-full mr-1">
                            {{ role.name }}
                            </span>
                        </TableCell>
                        <TableCell class="text-right space-x-2">
                            <Link
                                v-if="$can('update-admin')"
                                :href="route(config.admin_route_name + 'admins.edit', admin.id)"
                                class="text-blue-600 hover:underline"
                            >
                                Edit
                            </Link>
                            <DeleteDialog 
                                v-if="$can('delete-admin')"
                                :data="form.deleteDialog" 
                                :route="route(config.admin_route_name + 'admins.destroy', admin.id)" />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            
            <PaginationT :links="admins.links" />
        </div>
        <div class="mb-4" v-else>
            You don't have permission to view list.
        </div>
    </div>
    
</template>
