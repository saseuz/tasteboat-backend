<script setup>
import { LayoutDashboard, Users, Gavel, User, Earth, ShoppingBasket, Boxes } from 'lucide-vue-next';
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
        <li v-if="$can('view-user')">
            <Link 
                :href="route(config.admin_route_name + 'users.index')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'users.index') ? 'active': ''
                ]"
                >
                <User class="size-5" />
                User
            </Link>
        </li>
        <li v-if="$can('view-cuisine')">
            <Link 
                :href="route(config.admin_route_name + 'cuisines.index')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'cuisines.index') ? 'active': ''
                ]"
                >
                <Earth class="size-5" />
                Cuisine
            </Link>
        </li>
        <li v-if="$can('view-category')">
            <Link 
                :href="route(config.admin_route_name + 'categories.index')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'categories.index') ? 'active': ''
                ]"
                >
                <Boxes class="size-5" />
                Category
            </Link>
        </li>
        <li v-if="$can('view-ingredient')">
            <Link 
                :href="route(config.admin_route_name + 'ingredients.index')"
                :class="[
                    'sidebar_link',
                    route().current(config.admin_route_name + 'ingredients.index') ? 'active': ''
                ]"
                >
                <ShoppingBasket class="size-5" />
                Ingredient
            </Link>
        </li>
    </ul>
</template>