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
import { router, useForm } from '@inertiajs/vue3';
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';
import DeleteDialog from '@/Shared/DeleteDialog.vue';
import PaginationT from '@/Shared/PaginationT.vue';

let props = defineProps({
    recipes: Object,
    filter: String,
});

let form = useForm({
    deleteDialog: {
        title: 'Are you absolutely sure?',
        message: 'This action cannot be undone. This will permanently delete the recipe.'
    },
    breadscrumbs: [
        { label: 'Recipe' },
    ],
});

let filterForm = useForm({
    filter: props.filter || 'list',
})

const filterIndex = () => {
    filterForm.get(route(config.admin_route_name + 'recipes.index'));
};

</script>

<template>
    <Head title="recipe Management" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Recipe Management</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="flex justify-start mb-4">
            <form @change="filterIndex()">
                <label for="filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a filter</label>
                <select 
                    id="filter" 
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-model="filterForm.filter"
                >
                    <option value="list">View List</option>
                    <option value="trashed">View Trashed</option>
                </select>
            </form>
        </div>

        <div v-if="$can('view-recipe')">
            <Table class="bg-[#243447] rounded">
                <TableCaption>A list of your recent recipes.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                        ID
                        </TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>User</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="text-right">
                        Action
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="recipe in recipes.data" :key="recipe.id">
                        <TableCell class="font-medium">
                        {{ recipe.id}}
                        </TableCell>
                        <TableCell>{{ recipe.title  }}</TableCell>
                        <TableCell>{{ recipe.user.name  }}</TableCell>
                        <TableCell>
                            <span 
                                class="inline-block text-xs px-2 rounded-full mr-1"
                                :class="recipe.status === 'published' ? 'bg-blue-200 text-blue-800' : 'bg-red-200 text-red-800'"
                            >
                            {{ recipe.status }}
                            </span>
                        </TableCell>
                        <TableCell class="text-right space-x-2">
                            <Link
                                v-if="$can('view-recipe')"
                                :href="route(config.admin_route_name + 'recipes.show', recipe.id)"
                                class="text-blue-400 hover:underline"
                            >
                                Show
                            </Link>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <PaginationT :links="recipes.links" />

        </div>
        
        <div class="mb-4" v-else>
            You don't have permission to view list.
        </div>
    </div>
    
</template>
