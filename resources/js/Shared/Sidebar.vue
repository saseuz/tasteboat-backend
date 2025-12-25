<script setup>
import { LayoutDashboard, Users, Gavel, User, Earth, ShoppingBasket, Boxes, UtensilsCrossed, Cog, LayoutGrid } from 'lucide-vue-next';
import config from '@/helpers/config'

</script>

<template>
    <aside class="flex flex-col gap-y-4 border-r border-[#233648] bg-[#111a22] p-4 text-white overflow-y-auto w-64">
        <div class="flex items-center-gap-2 space-x-4 py-2">
            <img src="" alt="" class="w-6 bg-[#137fec]">
            <h2 class="text-white text-lg font-bold leading-tight tracking-[-0.015em]">{{ config.app_name  }}</h2>
        </div>

        <div class="pt-4 border-t border-slate-700/80">
            <h6 class="text-xs text-gray-200 font-bold px-1 mb-4 flex items-center gap-1">
                <LayoutGrid class="size-4" />
                <span>Application</span>
            </h6>

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
                <li v-if="$can('view-recipe')">
                    <Link 
                        :href="route(config.admin_route_name + 'recipes.index')"
                        :class="[
                            'sidebar_link',
                            route().current(config.admin_route_name + 'recipes.index') ? 'active': ''
                        ]"
                        >
                        <UtensilsCrossed class="size-5" />
                        Recipe
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
        </div>

        <div class="pt-4 border-t border-slate-700/80">
            <h6 class="text-xs text-gray-200 font-bold px-1 mb-4 flex items-center gap-1">
                <Cog class="size-4" />
                <span>System</span>
            </h6>
            
            <ul>
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
        </div>
    </aside>
    
</template>