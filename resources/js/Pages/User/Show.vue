<script setup>
import config from '@/helpers/config'
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';
import { useForm } from '@inertiajs/vue3';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog'

let props = defineProps({
    user: Object,
    user_status: String,
});

let form = useForm({
    status: props.user.status,
    breadscrumbs: [
        { label: 'User', url: route(config.admin_route_name + 'users.index') },
        { label: 'Details' },
    ],
});

const changeStatus = () => {
    console.log(props.user.status);
    form.post(route(config.admin_route_name + 'users.update-status', props.user.id), {
        onSuccess: () => {
            form.reset();
        },
    });
}

</script>

<template>
    <Head title="User Details" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">User Details</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="w-full max-w-full bg-gray-800 rounded shadow p-4" v-if="$can('update-user')">

            <ul>
                <li>Name: {{ user.name }}</li>
                <li>Email: {{ user.email }}</li>
                <li>Status: {{ user_status }}</li>
            </ul>

            <p class="my-2 font-bold text-sm">Do you want to {{ user.status == 'active' ? 'deactivate' : 'activate'  }} this account?</p>

            <AlertDialog>
                <AlertDialogTrigger 
                    class="mt-2 py-1 px-2 font-semibold rounded cursor-pointer transition shadow"
                    :class="user.status == 'active' ? 'bg-red-400 hover:bg-red-400/80' : 'bg-green-400 hover:bg-green-400/80'">
                    Click to {{ user.status == 'active' ? 'deactivate' : 'activate'  }}
                </AlertDialogTrigger>
                <AlertDialogContent>
                    <AlertDialogHeader>
                        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                        <AlertDialogDescription>
                            You want to {{ user.status == 'active' ? 'deactivate' : 'activate'  }} this account?
                        </AlertDialogDescription>
                    </AlertDialogHeader>
                    <AlertDialogFooter>
                        <AlertDialogCancel>Cancel</AlertDialogCancel>
                        <AlertDialogAction>
                            <Link
                                as="button"
                                @click.prevent="changeStatus"
                            >
                                Confirm
                            </Link>
                        </AlertDialogAction>
                    </AlertDialogFooter>
                </AlertDialogContent>
            </AlertDialog>

        </div>
        <div class="mb-4" v-else>
            You don't have permission to view detail.
        </div>
    </div>

</template>