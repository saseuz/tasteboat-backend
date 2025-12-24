<script setup>
import { computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import config from '@/helpers/config';
import { Bell, LogOut, PanelsTopLeft } from 'lucide-vue-next';
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
    
    <div class="relative flex flex-col min-h-screen w-full dark group/design-root">
        <div class="flex grow flex-row">
            <aside class="flex flex-col gap-y-4 border-r border-[#233648] bg-[#111a22] p-4 text-white overflow-y-auto w-64">
                <div class="flex items-center-gap-2 space-x-1 p-4">
                    <img src="" alt="" class="w-6 bg-[#137fec]">
                    <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">{{ config.app_name  }}</h2>
                </div>

                <Sidebar />
            </aside>

            <section class="flex flex-col w-full text-white">
                <header class="flex justify-between border-b border-[#2d3338] px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <span><PanelsTopLeft /></span>
                    </div>

                    <div class="flex items-center space-x-4">
                        <Bell />
                        <Link 
                            method="post"
                            :href="route(config.admin_route_name + 'logout')"
                            class="btn bg-secondary/90 hover:bg-secondary">
                            <LogOut size="16" />
                            Logout
                        </Link>
                    </div>
                </header>
                
                <main class="flex-grow p-6 bg-[#0b141e]">
                    <Toaster />

                    <slot />
                </main>
            </section>
        </div>

        <footer class="flex bg-secondary text-white justify-center items-center h-12">
            <p class="text-sm font-bold">&copy; {{ new Date().getFullYear() }} {{ config.app_name  }}. All rights reserved.</p>
        </footer>
    </div>

</template>