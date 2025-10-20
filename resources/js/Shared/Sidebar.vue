<script setup>
import { LayoutDashboard, Users, Gavel } from 'lucide-vue-next';
import config from '@/helpers/config'

</script>

<template>
    <ul class="text-sm">
        <li v-if="$can('view-dashboard')">
            <Link 
                :href="route(config.admin_route_name + 'dashboard')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'dashboard') ? 'active': ''
                ]"
                >
                <LayoutDashboard class="size-5" />
                <span>Dashboard</span>
            </Link>
        </li>
        <li v-if="$can('view-admin')">
            <Link 
                :href="route(config.admin_route_name + 'admins.index')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'admins.index') ? 'active': ''
                ]"
                >
                <Users class="size-5" />
                Admin
            </Link>
        </li>
        <li v-if="$can('view-role')">
            <Link 
                :href="route(config.admin_route_name + 'roles.index')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'roles.index') ? 'active': ''
                ]"
                >
                <Gavel class="size-5" />
                Role
            </Link>
        </li>
    </ul>
</template>