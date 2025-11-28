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
    ingredients: Object,
});

let form = useForm({
    deleteDialog: {
        title: 'Are you absolutely sure?',
        message: 'This action cannot be undone. This will permanently delete the ingredient.'
    },
    breadscrumbs: [
        { label: 'Ingredient' },
    ],
});
</script>

<template>
    <Head title="Ingredient Management" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Ingredient Management</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="flex justify-end mb-4">
            <Link 
                v-if="$can('create-ingredient')"
                :href="route(config.admin_route_name + 'ingredients.create')"
                class="flex items-center gap-2 bg-[#2a3f5f] hover:bg-[#2a3f5f]/50 text-white font-semibold py-2 px-4 rounded shadow transition"
            >
                <Plus /> Create
            </Link>
        </div>

        <div v-if="$can('view-ingredient')">
            <Table class="bg-[#243447] rounded">
                <TableCaption>A list of your recent ingredients.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">
                        ID
                        </TableHead>
                        <TableHead>Recipe</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead class="text-right">
                        Action
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="ingredient in ingredients.data" :key="ingredient.id">
                        <TableCell class="font-medium">
                        {{ ingredient.id}}
                        </TableCell>
                        <TableCell>{{ ingredient.recipe?.title || `In Trashed!`  }}</TableCell>
                        <TableCell>{{ ingredient.name  }}</TableCell>
                        <TableCell class="text-right space-x-2">
                            <!-- <Link
                                v-if="$can('view-ingredient')"
                                :href="route(config.admin_route_name + 'ingredients.show', ingredient.id)"
                                class="text-blue-400 hover:underline"
                            >
                                Show
                            </Link> -->
                            <Link
                                v-if="$can('update-ingredient')"
                                :href="route(config.admin_route_name + 'ingredients.edit', ingredient.id)"
                                class="text-blue-600 hover:underline"
                            >
                                Edit
                            </Link>
                            <DeleteDialog 
                                :data="form.deleteDialog" 
                                :route="route(config.admin_route_name + 'ingredients.destroy', ingredient.id)"
                                v-if="$can('delete-ingredient')"
                            />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <PaginationT :links="ingredients.links" />
        </div>
        <div class="mb-4" v-else>
            You don't have permission to view list.
        </div>
    </div>
    
</template>
