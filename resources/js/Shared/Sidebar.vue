<script setup>
import config from '@/helpers/config';
import { LayoutDashboard, Users, Gavel } from 'lucide-vue-next';

</script>

<template>
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
                :href="route(config.admin_route_name + 'admins.index')"
                class="flex items-center gap-3 my-1 p-2 rounded-md text-gray-400 hover:bg-[#137fec] hover:text-white transition fade-in-5"
                >
                <Users class="size-5" />
                Admin
            </Link>
        </li>
        <li>
            <Link 
                :href="route(config.admin_route_name + 'roles.index')"
                class="flex items-center gap-3 my-1 p-2 rounded-md text-gray-400 hover:bg-[#137fec] hover:text-white transition fade-in-5"
                >
                <Gavel class="size-5" />
                Role
            </Link>
        </li>
    </ul>
</template>