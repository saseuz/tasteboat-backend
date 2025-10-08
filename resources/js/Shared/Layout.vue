<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import config from '@/helpers/config';
import { Bell, LayoutDashboard, PanelsTopLeft, Users } from 'lucide-vue-next';

const page = usePage();

const username = computed(() => 
    page.props.auth?.user?.username || 'Guest'
)
</script>

<template>
    
    <div class="relative min-h-screen flex flex-col dark group/design-root">
        <div class="flex h-full grow flex-row">
            <aside class="flex flex-col h-screen gap-y-6 border-r border-[#233648] bg-[#111a22] p-4 text-white w-64">
                <div class="flex items-center-gap-2 space-x-1 px-4">
                    <img src="" alt="" class="w-6 bg-[#137fec]">
                    <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">{{ config.app_name  }}</h2>
                </div>

                <ul class="text-sm">
                    <li>
                        <Link 
                            :href="route(config.admin_route_name + 'dashboard')"
                            class="flex items-center gap-3 my-1 p-2 rounded-md text-gray-400 hover:bg-[#137fec] hover:text-white transition fade-in-5"
                            >
                            <LayoutDashboard class="size-5" />
                            <span>Dashboard</span>
                        </Link>
                    </li>
                    <li>
                        <Link 
                            :href="route(config.admin_route_name + 'dashboard')"
                            class="flex items-center gap-3 my-1 p-2 rounded-md text-gray-400 hover:bg-[#137fec] hover:text-white transition fade-in-5"
                            >
                            <Users class="size-5" />
                            User
                        </Link>
                    </li>
                </ul>

                <Link class="mt-auto bg-red-400">
                    Profile
                </Link>
            </aside>

            <section class="flex flex-col w-full text-white">
                <header class="flex justify-between border-b border-[#2d3338] px-6 py-4">
                    <div class="flex items-center space-x-2">
                        <span><PanelsTopLeft /></span>
                    </div>

                    <span><Bell /></span>
                </header>
            </section>
        </div>
    </div>

</template>