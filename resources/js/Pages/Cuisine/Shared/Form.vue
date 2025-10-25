<script setup>
import { useForm } from '@inertiajs/vue3'
import config from '@/helpers/config'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"

let props = defineProps({
    cuisine: Object,
    routeName: { type: String, default: 'cuisines.store' },
    isEdit: { type: Boolean, default: false },
});

let form = useForm({
    name: props.cuisine?.name || '',
    description: props.cuisine?.description || '', 
});

let submit = () => {
    let actionRoute = props.routeName;

    if (props.isEdit && props.cuisine) {
        form.put(route(config.admin_route_name + actionRoute, props.cuisine.id), {
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
                    <Label htmlFor="name" class="text-sm font-medium">
                        Name <span class="text-red-600">*</span>
                    </Label>
                    <Input id="name" type="text" v-model="form.name" required placeholder="Enter Cuisine Name" class="w-full shadow-xl" />
                    <span v-if="form.errors.name" class="text-red-600 text-sm font-medium">{{ form.errors.name }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="name" class="text-sm font-medium">
                        Description
                    </Label>
                    <textarea id="description" v-model="form.description" required placeholder="Enter Cuisine Description" class="w-full h-16 px-4 py-2 shadow-xl">
                    </textarea>
                    <span v-if="form.errors.description" class="text-red-600 text-sm font-medium">{{ form.errors.description }}</span>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <Button type="submit" class="bg-slate-700 hover:bg-slate-700/50 text-white transition font-semibold shadow-xl" :disabled="form.processing">
            Submit
            </Button>
            <Button asChild variant="outline" class="text-white bg-transparent">
                <Link :href="route(config.admin_route_name + 'cuisines.index')">Cancel</Link>
            </Button>
        </div>
    </form>
</template>