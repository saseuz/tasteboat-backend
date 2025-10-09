<script setup>
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
import { route } from 'ziggy-js';

let props = defineProps({
    data: Object,
    route: String,
});

</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger class="text-red-600 hover:underline">Delete</AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ props.data.title }}</AlertDialogTitle>
                <AlertDialogDescription>
                    {{ props.data.message }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>
                <AlertDialogAction asChild>
                    <Link
                        :href="props.route"
                        method="delete"
                        as="button"
                        class="bg-red-600 hover:bg-red-600/80 text-white font-semibold py-2 px-4 rounded shadow transition"
                    >
                        Confirm
                    </Link>
                </AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>