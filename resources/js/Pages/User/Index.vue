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

let props = defineProps({
    users: Object,
});

let form = useForm({
    breadscrumbs: [
        { label: 'User' },
    ],
    deleteDialog: {
        title: 'Are you absolutely sure?',
        message: 'This action cannot be undone. This will permanently delete.',
    }
});

</script>

<template>
    <Head title="User Management" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">User Management</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <!-- <div class="flex justify-end mb-4">
            <Link 
                v-if="$can('create-user')"
                :href="route(config.admin_route_name + 'users.create')"
                class="flex items-center gap-2 bg-[#2a3f5f] hover:bg-[#2a3f5f]/50 text-white font-semibold py-2 px-4 rounded shadow transition"
            >
                <Plus /> Create
            </Link>
        </div> -->
        <Table class="bg-[#243447] rounded" v-if="$can('view-user')">
            <TableCaption>A list of your recent users.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]">
                    ID
                    </TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead class="text-right">
                    Action
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <TableRow v-for="user in users.data" :key="user.id">
                    <TableCell class="font-medium">
                    {{ user.id}}
                    </TableCell>
                    <TableCell>{{ user.name  }}</TableCell>
                    <TableCell>{{ user.email }}</TableCell>
                    <TableCell>
                        <span 
                            class="inline-block text-xs uppercase px-2 rounded mr-1"
                            :class="user.status == 'active' ? 'bg-blue-200 text-blue-800' : 'bg-red-200 text-red-800'"
                        >
                            {{ user.status }}
                        </span>
                    </TableCell>
                    <TableCell class="text-right space-x-2">
                        <Link
                            v-if="$can('update-user')"
                            :href="route(config.admin_route_name + 'users.show', user.id)"
                            class="text-blue-400 hover:underline"
                        >
                            Show
                        </Link>
                        <DeleteDialog 
                            v-if="$can('delete-user')"
                            :data="form.deleteDialog" 
                            :route="route(config.admin_route_name + 'users.destroy', user.id)" />
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
        <div class="mb-4" v-else>
            You don't have permission to view list.
        </div>
    </div>
    
</template>
