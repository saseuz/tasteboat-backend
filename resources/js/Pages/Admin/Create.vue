<script setup>
import config from '@/helpers/config'
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"
import { useForm } from '@inertiajs/vue3'

let props = defineProps({
    roles: Object,
});

let form = useForm({
    email: '',
    password: '',
    name: '',
    role: '',
});

let submit = () => {
    console.log('submit', form);
    // form.post('/users');
}

</script>

<template>
    <Head title="Admin Create" />

    <div class="mb-6">
        <Breadcrumb>
            <BreadcrumbList>
                <BreadcrumbItem>
                    <BreadcrumbLink :href="route(config.admin_route_name + 'dashboard')">
                    Dashboard
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbLink :href="route(config.admin_route_name + 'admins.index')">
                    Admin
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbPage>Create</BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Admin Create</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <form @submit.prevent="submit" class="w-full max-w-full p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                <div class="space-y-2">
                    <Label htmlFor="email" class="text-sm font-medium">
                        Email <span class="text-red-600">*</span>
                    </Label>
                    <Input id="email" type="email" v-model="form.email" placeholder="Enter Email" required class="w-full shadow-xl" />
                </div>

                <div class="space-y-2">
                    <Label htmlFor="password" class="text-sm font-medium">
                        Password <span class="text-red-600">*</span>
                    </Label>
                    <Input id="password" type="password" v-model="form.password" placeholder="Enter Password" required class="w-full shadow-xl" />
                </div>

                <div class="space-y-2">
                    <Label htmlFor="name" class="text-sm font-medium">
                        Name <span class="text-red-600">*</span>
                    </Label>
                    <Input id="name" type="text" v-model="form.name" placeholder="Enter Name" required class="w-full shadow-xl" />
                </div>

                <div class="space-y-2">
                    <Label htmlFor="confirm-password" class="text-sm font-medium">
                        Confirm Password <span class="text-red-600">*</span>
                    </Label>
                    <Input id="confirm-password" type="password" placeholder="Confirm Password" required class="w-full shadow-xl" />
                </div>

                <div class="space-y-2 md:col-span-1">
                    <Label htmlFor="role" class="text-sm font-medium">
                        Role <span class="text-red-600">*</span>
                    </Label>
                    <Select required v-model="form.role">
                        <SelectTrigger id="role" class="w-full shadow-xl">
                            <SelectValue placeholder="Select Role" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="(role, index) in roles" :key="index" :value="role">{{ role }}</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
            </div>

            <div class="flex gap-3 mt-8">
                <Button type="submit" class="bg-slate-700 hover:bg-slate-700/50 text-white transition font-semibold shadow-xl">
                Submit
                </Button>
                <Button asChild variant="outline" class="text-white bg-transparent">
                    <Link :href="route(config.admin_route_name + 'admins.index')">Cancel</Link>
                </Button>
            </div>
        </form>
    </div>
</template>