<script setup>
import { computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import config from '@/helpers/config';
import { Bell, LogOut, PanelsTopLeft } from 'lucide-vue-next';
import Sidebar from '@/Shared/Sidebar.vue';
import { Toaster } from '@/components/ui/sonner'
import 'vue-sonner/style.css'
import { toast } from 'vue-sonner'
import Footer from './Footer.vue';

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
        <meta name="description" content="Tasteboat Admin Panel" head-key="description" />
        <link rel="icon" type="image/x-icon" href="/favicon.svg" />
    </Head>
    
    <div class="relative flex flex-col min-h-screen w-full dark group/design-root">
        <div class="flex grow flex-row">
            <Sidebar />

            <section class="flex flex-col w-full text-white">
                <header class="flex justify-between border-b border-[#2d3338] px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <PanelsTopLeft />
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

        <Footer />
    </div>

</template>