<script setup>
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';
import { useForm } from '@inertiajs/vue3';
import { BottleWine, ChartNoAxesGantt, Plus, Star, Users, Utensils } from 'lucide-vue-next';
import config from '@/helpers/config'

let form = useForm({
    breadscrumbs: [
        { label: 'Dashboard Management' },
    ]
});

</script>

<template>
    <Head title="Dashboard" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="text-primary mb-4">
        <h1 class="text-xl">System Overview</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-sky-900/60 backdrop-blur-2xl flex flex-col gap-4 p-6 rounded-sm shadow-xl drop-shadow-black hover:scale-102 overflow-hidden transition duration-300">
            <div class="flex items-end gap-2">
                <div class="bg-sky-800 p-2 rounded">
                    <Users size="20" class="stroke-2" />
                </div>
                <h6 class="text-xl font-medium">Total Users</h6>
            </div>
            <h5 class="text-3xl font-semibold">2,032</h5>
        </div>

        <div class="bg-yellow-900/60 backdrop-blur-2xl flex flex-col gap-4 p-6 rounded-sm shadow-xl drop-shadow-black hover:scale-102 overflow-hidden transition duration-300">
            <div class="flex items-end gap-2">
                <div class="bg-yellow-800 p-2 rounded">
                    <Utensils size="20" class="stroke-2" />
                </div>
                <h6 class="text-xl font-medium">Total Recipes</h6>
            </div>
            <h5 class="text-3xl font-semibold">3,129</h5>
        </div>

        <div class="bg-teal-900/60 backdrop-blur-2xl flex flex-col gap-4 p-6 rounded-sm shadow-xl drop-shadow-black hover:scale-102 overflow-hidden transition duration-300">
            <div class="flex items-end gap-2">
                <div class="bg-teal-800 p-2 rounded">
                    <BottleWine size="20" class="stroke-2" />
                </div>
                <h6 class="text-xl font-medium">Total Ingredients</h6>
            </div>
            <h5 class="text-3xl font-semibold">6,222</h5>
        </div>

        <div class="bg-violet-900/60 backdrop-blur-2xl flex flex-col gap-4 p-6 rounded-sm shadow-xl drop-shadow-black hover:scale-102 overflow-hidden transition duration-300">
            <div class="flex items-end gap-2">
                <div class="bg-violet-800 p-2 rounded">
                    <Star size="20" class="stroke-2" />
                </div>
                <h6 class="text-xl font-medium">Avg Rating</h6>
            </div>
            <h5 class="text-3xl font-semibold flex gap-2 items-center">
                <span>4.5</span> 
                <div class="flex gap-1">     
                    <Star size="22" class="stroke-2 fill-yellow-500 stroke-yellow-500" />
                    <Star size="22" class="stroke-2 fill-yellow-500 stroke-yellow-500" />
                    <Star size="22" class="stroke-2 fill-yellow-500 stroke-yellow-500" />
                    <Star size="22" class="stroke-2 fill-yellow-500 stroke-yellow-500" />
                    <Star size="22" class="stroke-2 fill-yellow-500 stroke-yellow-500" />
                </div>
            </h5>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4">
        <div class="card w-full md:w-2/5 mt-4">
            <div class="card-header">
                <h6 class="card-header-title">Recent Recipes</h6>
            </div>
            <div class="card-body">
                <div class="flex gap-4 border-b border-slate-700/80 px-2 py-4 hover:bg-slate-700/80 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="" class="w-16 h-16 rounded">
                    <div class="flex justify-between w-full">
                        <div class="flex flex-col justify-around">
                            <h5 class="text-lg font-medium">Thai Green Curry</h5>
                            <p class="text-sm text-slate-400">By Erluekin</p>
                        </div>
                        <span class="text-sm text-slate-400">2 hours ago</span>
                    </div>
                </div>

                <div class="flex gap-4 border-b border-slate-700/80 px-2 py-4 hover:bg-slate-700/80 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="" class="w-16 h-16 rounded">
                    <div class="flex justify-between w-full">
                        <div class="flex flex-col justify-around">
                            <h5 class="text-lg font-medium">Beef Red Curry</h5>
                            <p class="text-sm text-slate-400">By Erluekin</p>
                        </div>
                        <span class="text-sm text-slate-400">4 hours ago</span>
                    </div>
                </div>

                <div class="flex gap-4 border-b border-slate-700/80 px-2 py-4 hover:bg-slate-700/80 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="" class="w-16 h-16 rounded">
                    <div class="flex justify-between w-full">
                        <div class="flex flex-col justify-around">
                            <h5 class="text-lg font-medium">Beef Red Curry</h5>
                            <p class="text-sm text-slate-400">By Erluekin</p>
                        </div>
                        <span class="text-sm text-slate-400">4 hours ago</span>
                    </div>
                </div>

                <div class="flex gap-4 border-b border-slate-700/80 px-2 py-4 hover:bg-slate-700/80 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="" class="w-16 h-16 rounded">
                    <div class="flex justify-between w-full">
                        <div class="flex flex-col justify-around">
                            <h5 class="text-lg font-medium">Beef Red Curry</h5>
                            <p class="text-sm text-slate-400">By Erluekin</p>
                        </div>
                        <span class="text-sm text-slate-400">4 hours ago</span>
                    </div>
                </div>

                <div class="flex gap-4 border-b border-slate-700/80 px-2 py-4 hover:bg-slate-700/80 transition duration-300">
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061" alt="" class="w-16 h-16 rounded">
                    <div class="flex justify-between w-full">
                        <div class="flex flex-col justify-around">
                            <h5 class="text-lg font-medium">Beef Red Curry</h5>
                            <p class="text-sm text-slate-400">By Erluekin</p>
                        </div>
                        <span class="text-sm text-slate-400">4 hours ago</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-3/5 mt-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-header-title">Recent Users</h6>
                </div>
                <div class="card-body flex gap-4">
                    <div class="w-full flex gap-4 border-slate-700/80 p-2 hover:bg-slate-700/80 transition duration-300 border-r">
                        <div>
                            <img src="https://plus.unsplash.com/premium_photo-1677252438425-e4125f74fbbe" alt="" class="w-12 h-12 rounded-full">
                        </div>
                        <div>
                            <h5 class="text-lg font-medium">John Doe</h5>
                            <p class="text-sm text-slate-400">2 hours ago</p>
                        </div>
                    </div>

                    <div class="w-full flex gap-4 border-slate-700/80 p-2 hover:bg-slate-700/80 transition duration-300">
                        <div>
                            <img src="https://plus.unsplash.com/premium_photo-1677252438425-e4125f74fbbe" alt="" class="w-12 h-12 rounded-full">
                        </div>
                        <div>
                            <h5 class="text-lg font-medium">John Doe</h5>
                            <p class="text-sm text-slate-400">2 hours ago</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body flex flex-col md:flex-row gap-4">
                    <div class="w-full md:flex-1/2">
                        <h5 class="text-lg font-medium border-b border-slate-700/80 pb-2 ">Quick Adds</h5>

                        <div class="mt-4 space-y-2 bg-slate-700 rounded p-2">
                            <Link 
                                v-if="$can('create-admin')"
                                :href="route(config.admin_route_name + 'admins.create')" 
                                class="btn bg-indigo-900/70 hover:bg-indigo-900/80 text-current/80"
                            >
                                <div class="p-1 rounded bg-indigo-700">
                                    <Plus size="20" />
                                </div>
                                <span>Add Admin</span>
                            </Link>
                            <Link 
                                v-if="$can('create-role')"
                                :href="route(config.admin_route_name + 'roles.create')" 
                                class="btn bg-purple-900/70 hover:bg-purple-900/80 text-current/80"
                            >
                                <div class="p-1 rounded bg-purple-700">
                                    <Plus size="20" />
                                </div>
                                <span>Add Role</span>
                            </Link>
                            <Link 
                                v-if="$can('create-cuisine')"
                                :href="route(config.admin_route_name + 'cuisines.create')" 
                                class="btn bg-violet-900/70 hover:bg-violet-900/80 text-current/80"
                            >
                                <div class="p-1 rounded bg-violet-700">
                                    <Plus size="20" />
                                </div>
                                <span>Add Cuisine</span>
                            </Link>
                            <Link 
                                v-if="$can('create-category')"
                                :href="route(config.admin_route_name + 'categories.create')" 
                                class="btn bg-amber-600/70 hover:bg-amber-600/80 text-current/80"
                            >
                                <div class="p-1 rounded bg-amber-500">
                                    <Plus size="20" />
                                </div>
                                <span>Add Category</span>
                            </Link>
                            <Link 
                                v-if="$can('create-ingredient')"
                                :href="route(config.admin_route_name + 'ingredients.create')" 
                                class="btn bg-green-900/70 hover:bg-green-900/80 text-current/80"
                            >
                                <div class="p-1 rounded bg-green-700">
                                    <Plus size="20" />
                                </div>
                                <span>Add Ingredient</span>
                            </Link>
                        </div>
                    </div>

                    <div class="w-full md:flex-1/2">
                        <h5 class="text-lg font-medium border-b border-slate-700/80 pb-2 ">Quick Management</h5>

                        <div class="mt-4 space-y-2 bg-slate-700 rounded p-2">

                            <Link 
                                v-if="$can('view-admin')"
                                :href="route(config.admin_route_name + 'admins.index')" 
                                class="btn bg-indigo-900/70 hover:bg-indigo-900/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Admin</span>
                            </Link>

                            <Link 
                                v-if="$can('view-role')"
                                :href="route(config.admin_route_name + 'roles.index')" 
                                class="btn bg-purple-900/70 hover:bg-purple-900/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Role</span>
                            </Link>

                            <Link 
                                v-if="$can('view-user')"
                                :href="route(config.admin_route_name + 'users.index')" 
                                class="btn bg-slate-900/70 hover:bg-slate-900/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Users</span>
                            </Link>

                            <Link 
                                v-if="$can('view-cuisine')"
                                :href="route(config.admin_route_name + 'cuisines.index')" 
                                class="btn bg-violet-900/70 hover:bg-violet-900/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Cuisine</span>
                            </Link>

                            <Link 
                                v-if="$can('view-category')"
                                :href="route(config.admin_route_name + 'categories.index')" 
                                class="btn bg-amber-600/70 hover:bg-amber-600/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Category</span>
                            </Link>

                            <Link 
                                v-if="$can('view-recipe')"
                                :href="route(config.admin_route_name + 'recipes.index')" 
                                class="btn bg-emerald-900/70 hover:bg-emerald-900/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Recipes</span>
                            </Link>

                            <Link 
                                v-if="$can('view-ingredient')"
                                :href="route(config.admin_route_name + 'ingredients.index')" 
                                class="btn bg-green-900/70 hover:bg-green-900/80 text-current/80"
                            >
                                <ChartNoAxesGantt size="20" />
                                <span>Manage Ingredient</span>
                            </Link>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
