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
import PaginationT from '@/Shared/PaginationT.vue';

let props = defineProps({
    categories: Object,
});

let form = useForm({
    deleteDialog: {
        title: 'Are you absolutely sure?',
        message: 'This action cannot be undone. This will permanently delete the category.'
    },
    breadscrumbs: [
        { label: 'Category' },
    ],
});
</script>

<template>
    <Head title="Category Management" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Category Management</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="flex justify-end mb-4">
            <Link 
                v-if="$can('create-category')"
                :href="route(config.admin_route_name + 'categories.create')"
                class="flex items-center gap-2 bg-[#2a3f5f] hover:bg-[#2a3f5f]/50 text-white font-semibold py-2 px-4 rounded shadow transition"
            >
                <Plus /> Create
            </Link>
        </div>
        <div v-if="$can('view-category')">
            <Table class="bg-[#243447] rounded">
                <TableCaption>A list of your recent categories.</TableCaption>
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
                    <TableRow v-for="category in categories.data" :key="category.id">
                        <TableCell class="font-medium">
                        {{ category.id}}
                        </TableCell>
                        <TableCell>{{ category.name  }}</TableCell>
                        <TableCell class="text-right space-x-2">
                            <!-- <Link
                                v-if="$can('assign-permissions')"
                                :href="route(config.admin_route_name + 'categories.show', category.id)"
                                class="text-blue-400 hover:underline"
                            >
                                Show
                            </Link> -->
                            <Link
                                v-if="$can('update-category')"
                                :href="route(config.admin_route_name + 'categories.edit', category.id)"
                                class="text-blue-600 hover:underline"
                            >
                                Edit
                            </Link>
                            <DeleteDialog 
                                :data="form.deleteDialog" 
                                :route="route(config.admin_route_name + 'categories.destroy', category.id)"
                                v-if="$can('delete-category')"
                            />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <PaginationT :links="categories.links" />
        </div>
        <div class="mb-4" v-else>
            You don't have permission to view list.
        </div>
    </div>
    
</template>
