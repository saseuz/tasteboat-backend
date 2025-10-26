<script setup>
import { useForm } from '@inertiajs/vue3'
import config from '@/helpers/config'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select"

let props = defineProps({
    recipes: Object,
    ingredient: Object,
    routeName: { type: String, default: 'ingredients.store' },
    isEdit: { type: Boolean, default: false },
});

let form = useForm({
    name: props.ingredient?.name || '',
    quantity: props.ingredient?.quantity || '',
    unit: props.ingredient?.unit || '',
    note: props.ingredient?.note || '',
    recipe_id: props.ingredient?.recipe_id || '',
});

let submit = () => {
    let actionRoute = props.routeName;

    if (props.isEdit && props.ingredient) {
        form.put(route(config.admin_route_name + actionRoute, props.ingredient.id), {
            onSuccess: () => {
                form.reset();
            },
        });
    } else {
        form.post(route(config.admin_route_name + actionRoute), {
            onSuccess: () => {
                form.reset();
            },
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="w-full max-w-full bg-gray-800 rounded shadow p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <div class="space-y-4">
                <div class="space-y-2">
                    <Label htmlFor="recipe" class="text-sm font-medium">
                        Recipe <span class="text-red-600">*</span>
                    </Label>
                    <!-- <Input id="recipe" type="text" v-model="form.recipe" required placeholder="Enter Recipe" class="w-full shadow-xl" /> -->
                     <Select v-model="form.recipe_id" class="w-full shadow-xl">
                        <SelectTrigger class="w-full" required>
                            <SelectValue placeholder="Select a Recipe" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Recipes</SelectLabel>
                                <SelectItem v-for="(recipe, id) in recipes" :key="id" :value="id">
                                    {{  recipe  }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <span v-if="form.errors.recipe" class="text-red-600 text-sm font-medium">{{ form.errors.recipe }}</span>
                </div>
                <div class="space-y-2">
                    <Label htmlFor="name" class="text-sm font-medium">
                        Name <span class="text-red-600">*</span>
                    </Label>
                    <Input id="name" type="text" v-model="form.name" required placeholder="Enter Cuisine Name" class="w-full shadow-xl" />
                    <span v-if="form.errors.name" class="text-red-600 text-sm font-medium">{{ form.errors.name }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="quantity" class="text-sm font-medium">
                        Quantity <span class="text-red-600">*</span>
                    </Label>
                    <Input id="quantity" type="text" v-model="form.quantity" required placeholder="Enter Quantity" class="w-full shadow-xl" />
                    <span v-if="form.errors.quantity" class="text-red-600 text-sm font-medium">{{ form.errors.quantity }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="unit" class="text-sm font-medium">
                        Unit
                    </Label>
                    <Input id="unit" type="text" v-model="form.unit" placeholder="Enter Unit" class="w-full shadow-xl" />
                    <span v-if="form.errors.unit" class="text-red-600 text-sm font-medium">{{ form.errors.unit }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="note" class="text-sm font-medium">
                        Note
                    </Label>
                    <textarea id="note" v-model="form.note" placeholder="Enter Cuisine Note" class="w-full px-4 py-2 shadow-xl" rows="4">
                    </textarea>
                    <span v-if="form.errors.note" class="text-red-600 text-sm font-medium">{{ form.errors.note }}</span>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <Button type="submit" class="bg-slate-700 hover:bg-slate-700/50 text-white transition font-semibold shadow-xl" :disabled="form.processing">
            Submit
            </Button>
            <Button asChild variant="outline" class="text-white bg-transparent">
                <Link :href="route(config.admin_route_name + 'ingredients.index')">Cancel</Link>
            </Button>
        </div>
    </form>
</template>