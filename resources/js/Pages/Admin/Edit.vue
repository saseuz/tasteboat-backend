<script setup>
import config from '@/helpers/config'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { useForm } from '@inertiajs/vue3'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue'

let props = defineProps({
    admin: Object,
    current_role: [String, Number],
    roles: Object,
});

let form = useForm({
    email: props.admin.email,
    password: '',
    password_confirmation: '',
    old_password: '',
    name: props.admin.name,
    role: props.current_role,
    breadscrumbs: [
        { label: 'Admin', url: route(config.admin_route_name + 'admins.index') },
        { label: 'Edit' },
    ],
});

let submit = () => {
    form.put(route(config.admin_route_name + 'admins.update', props.admin.id), {
        onSuccess: () => {
            form.reset();
        },
    });
};

</script>

<template>
    <Head title="Admin Edit" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Admin Edit</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <form 
            @submit.prevent="submit" 
            class="w-full max-w-full bg-gray-800 rounded shadow p-4"
            v-if="$can('update-admin')"
        >
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                <div class="space-y-2">
                    <Label htmlFor="email" class="text-sm font-medium">
                        Email <span class="text-red-600">*</span>
                    </Label>
                    <Input id="email" type="email" v-model="form.email" required placeholder="Enter Email" class="w-full shadow-xl" />
                    <span v-if="form.errors.email" class="text-red-600 text-sm font-medium">{{ form.errors.email }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="password" class="text-sm font-medium">
                        Old Password<span class="text-red-600">*</span>
                    </Label>
                    <Input id="password" type="password" v-model="form.old_password" placeholder="Enter Old Password" class="w-full shadow-xl" />
                    <span v-if="form.errors.old_password" class="text-red-600 text-sm font-medium">{{ form.errors.old_password }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="name" class="text-sm font-medium">
                        Name <span class="text-red-600">*</span>
                    </Label>
                    <Input id="name" type="text" v-model="form.name" required placeholder="Enter Name" class="w-full shadow-xl" />
                    <span v-if="form.errors.name" class="text-red-600 text-sm font-medium">{{ form.errors.name }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="password" class="text-sm font-medium">
                        Password <span class="text-red-600">*</span>
                    </Label>
                    <Input id="password" type="password" v-model="form.password" placeholder="Enter Password" class="w-full shadow-xl" />
                    <span v-if="form.errors.password" class="text-red-600 text-sm font-medium">{{ form.errors.password }}</span>
                </div>

                <div class="space-y-2 md:col-span-1">
                    <Label htmlFor="role" class="text-sm font-medium">
                        Role <span class="text-red-600">*</span>
                    </Label>
                    <Select v-model="form.role" required>
                        <SelectTrigger id="role" class="w-full shadow-xl">
                            <SelectValue placeholder="Select Role" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="(role, index) in roles" :key="index" :value="role">{{ role }}</SelectItem>
                        </SelectContent>
                    </Select>
                    <span v-if="form.errors.role" class="text-red-600 text-sm font-medium">{{ form.errors.role }}</span>
                </div>

                <div class="space-y-2">
                    <Label htmlFor="confirm_password" class="text-sm font-medium">
                        Confirm Password <span class="text-red-600">*</span>
                    </Label>
                    <Input id="confirm_password" type="password" v-model="form.password_confirmation" placeholder="Confirm Password" class="w-full shadow-xl" />
                    <span v-if="form.errors.password" class="text-red-600 text-sm font-medium">{{ form.errors.password }}</span>
                </div>

            </div>

            <div class="flex gap-3 mt-8">
                <Button type="submit" class="bg-slate-700 hover:bg-slate-700/50 text-white transition font-semibold shadow-xl" :disabled="form.processing">
                Submit
                </Button>
                <Button asChild variant="outline" class="text-white bg-transparent">
                    <Link :href="route(config.admin_route_name + 'admins.index')">Cancel</Link>
                </Button>
            </div>
        </form>
        <div class="my-4" v-else>
            You don't have permission to edit.
        </div>
    </div>
</template>