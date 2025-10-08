<script>
export default {
    layout: null,
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import config from '@/helpers/config'

let form = useForm({
    email: "",
    password: "",
});

let submit = () => {
    form.post(route(`${config.admin_route_name}login`));
};
</script>

<template>
    <Head title="Login" />

    <Card class="max-w-md mx-auto mt-[20vh]">
        <CardHeader>
            <CardTitle>Welcome to TasteBoat</CardTitle>
            <CardDescription>Login for control panel.</CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit">
                <div class="grid items-center w-full gap-4">
                    <div class="flex flex-col space-y-1.5">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            v-model="form.email"
                            type="email"
                            name="email"
                            placeholder="Enter your E-mail"
                            required
                        />
                        <div
                            v-if="form.errors.email"
                            v-text="form.errors.email"
                            class="text-red-500 text-xs mt-1"
                        ></div>
                    </div>
                    <div class="flex flex-col space-y-1.5">
                        <Label for="password">Password</Label>
                        <Input
                            id="password"
                            v-model="form.password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        />
                        <div
                            v-if="form.errors.password"
                            v-text="form.errors.password"
                            class="text-red-500 text-xs mt-1"
                        ></div>
                    </div>
                </div>

                <Button :disabled="form.processing" class="mt-4">
                    Sign In
                </Button>
            </form>
        </CardContent>
	</Card>
</template>
