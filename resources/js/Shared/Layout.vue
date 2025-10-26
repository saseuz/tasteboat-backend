<script setup>
import { computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import config from '@/helpers/config';
import { Bell, PanelsTopLeft } from 'lucide-vue-next';
import Sidebar from '@/Shared/Sidebar.vue';
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import { toast } from 'vue-sonner'

const page = usePage();

const username = computed(() => 
    page.props.auth?.user?.username
)

const flashSuccess = computed(() =>
    page.props.flash?.success
)

const flashError = computed(() =>
    page.props.flash?.error
)

watch(flashSuccess, (value) => {
    if (value) {
        toast.success("Success!", {
            description: value
        });
    }
});

watch(flashError, (value) => {
    if (value) {
        toast.error("Something Went Wrong!", {
            description: value
        });
    }
});
</script>

<template>

    <Head>
        <title>{{ config.app_name  }}</title>
        <meta name="description" content="A simple Inertia.js app with vue3" head-key="description" />
    </Head>
    
    <div class="relative min-h-screen flex flex-col dark group/design-root">
        <div class="flex h-full grow flex-row">
            <aside class="flex flex-col h-screen gap-y-6 border-r border-[#233648] bg-[#111a22] p-4 text-white w-64">
                <div class="flex items-center-gap-2 space-x-1 px-4">
                    <img src="" alt="" class="w-6 bg-[#137fec]">
                    <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">{{ config.app_name  }}</h2>
                </div>

                <Sidebar />

                <Link 
                    method="post"
                    :href="route(config.admin_route_name + 'logout')"
                    class="mt-auto bg-red-400">
                    Logout
                </Link>
            </aside>

            <section class="flex flex-col w-full text-white">
                <header class="flex justify-between border-b border-[#2d3338] px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <span><PanelsTopLeft /></span>
                    </div>

                    <span><Bell /></span>
                </header>

                
                <main class="flex-grow p-6 bg-[#0b141e]">
                    <Toaster />

                    <slot />
                </main>
            </section>
        </div>
    </div>

</template>