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
    recipes: Object,
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
        <div class="flex justify-end mb-4">
            <!-- <Link 
                v-if="$can('create-recipe')"
                :href="route(config.admin_route_name + 'recipes.create')"
                class="flex items-center gap-2 bg-[#2a3f5f] hover:bg-[#2a3f5f]/50 text-white font-semibold py-2 px-4 rounded shadow transition"
            >
                <Plus /> Create
            </Link> -->
        </div>
        <Table class="bg-[#243447] rounded" v-if="$can('view-recipe')">
            <TableCaption>A list of your recent recipes.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead class="w-[100px]">
                    ID
                    </TableHead>
                    <TableHead>Title</TableHead>
                    <TableHead>User</TableHead>
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
        <div class="mb-4" v-else>
            You don't have permission to view list.
        </div>
    </div>
    
</template>
