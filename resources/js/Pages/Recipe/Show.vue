<script setup>
import config from '@/helpers/config'

import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import BreadcrumbT from '@/Shared/BreadcrumbT.vue';
import { Boxes, CalendarClock, CalendarDays, ChartColumnIncreasingIcon, ClockFading, Earth, Heart, Star, User, Users } from 'lucide-vue-next';
import CommentItem from './Shared/CommentItem.vue';
import CommentsList from './Shared/CommentsList.vue';

let props = defineProps({
    recipe: Object,
    avg_ratings: Number,
    categories: Object,
    c_count: Number,
    comments: Object,
    ingredients: Object,
    favourite_count: Number,
});

let form = useForm({
    status: props.recipe.status,
    breadscrumbs: [
        { label: 'Recipe', url: route(config.admin_route_name + 'recipes.index') },
        { label: 'Details' },
    ],
});

let toggleStatus = () => {
    form.post(route(config.admin_route_name + 'recipes.toggleStatus', props.recipe.id), {
        onSuccess: () => {
            form.reset();
        },
    });
}

let toggleTrashed = () => {
    form.post(route(config.admin_route_name + 'recipes.toggleTrashed', props.recipe.id), {
        onSuccess: () => {
            form.reset();
        },
    });
}

</script>

<template>
    <Head title="Recipe Details" />

    <div class="mb-6">
        <BreadcrumbT :items="form.breadscrumbs" />
    </div>

    <div class="bg-secondary p-4 rounded shadow text-primary">
        <h1 class="text-xl">Recipe Details</h1>
    </div>

    <div class="mt-4 bg-secondary p-4 rounded shadow text-primary">
        <div class="w-full max-w-full bg-gray-800 rounded shadow p-4" v-if="$can('view-recipe')">
            <!-- Created At/User -->
            <div class="flex justify-between mb-5">
                <div class="flex gap-2">
                    <button 
                        class="focus:outline-none text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
                        :class="recipe.status === 'published' ? 'bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 focus:ring-red-300 dark:focus:ring-red-900' : 'bg-cyan-700 hover:bg-cyan-800 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:ring-cyan-300 dark:focus:ring-cyan-900'"
                        @click="toggleStatus()"
                        :disabled="form.processing"
                    >
                        {{ recipe.status === 'draft' ? 'Make Publish' : 'Make Draft' }}
                    </button>
                    <button 
                        class="focus:outline-none text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
                        :class="recipe.deleted_at === null ? 'bg-red-700 hover:bg-red-800 dark:bg-red-600 dark:hover:bg-red-700 focus:ring-red-300 dark:focus:ring-red-900' : 'bg-cyan-700 hover:bg-cyan-800 dark:bg-cyan-600 dark:hover:bg-cyan-700 focus:ring-cyan-300 dark:focus:ring-cyan-900'"
                        @click="toggleTrashed()"
                        :disabled="form.processing"
                    >
                        {{ recipe.deleted_at === null ? 'Move to Trash' : 'Remove from Trash' }}
                    </button>
                </div>
                <div class="flex flex-col mb-2">
                    <div class="flex space-x-1 text-sm">
                        <CalendarDays class="size-4 text-lime-500" /> 
                        <span>{{ recipe.created_at }}</span>
                    </div>
                    <div class="flex space-x-1 text-sm">
                        <User class="size-4 text-red-500" />
                        <span>{{ recipe.user.name }}</span>
                    </div>
                </div>
            </div>

            <div class="grid xs:grid-cols-1 grid-cols-3 gap-4">

                <!-- Image -->
                <div class="xs:col-span-3">
                    <div class="bg-slate-900 max-w-full h-auto">
                        <img class="max-w-full h-auto bg-red-900" src="https://placehold.co/600x400" :alt="recipe.title">
                    </div>
                </div>

                <div class="xs:col-span-3 col-span-2">
                    <!-- Title/Status -->
                    <h4 class="text-2xl font-bold dark:text-white mb-2">
                        {{ recipe.title }} 
                        <small 
                            class="ml-2 px-1 py-0.5 rounded bg-blue-500/40 text-blue-200"
                            :class="recipe.status === 'published' ? 'bg-blue-500/40 text-blue-200' : 'bg-red-500/40 text-red-200'"
                            >
                            {{ recipe.status  }}
                        </small>
                    </h4>
    
                    <!-- Cusine/Category/Ratings -->
                    <div class="flex justify-between mb-1">
                        <div class="flex space-x-2">
                            <div class="flex space-x-1 text-sm">
                                <Earth class="size-4 text-green-500" />
                                <span class="font-semibold">{{ recipe.cuisine.name }}</span>
                            </div>
                            <div class="flex space-x-1 text-sm">
                                <Boxes class="size-4 text-purple-500" />
                                <span 
                                    class="font-semibold" 
                                    v-for="(category, index) in categories" 
                                    :key="category"
                                >
                                {{ category }} <span v-if="index < categories.length - 1">|</span>
                                </span>
                                <span v-if="c_count > categories.length">...</span>
                            </div>
                            <div class="flex space-x-1 text-sm">
                                <Heart class="size-4 text-red-500" />
                                <span class="font-semibold">{{ favourite_count }}</span>
                            </div>
                        </div>
                        <div class="flex space-x-1 text-sm px-3 py-1 rounded bg-amber-500/40 text-amber-400">
                            <Star size="16" />
                            <span class="font-bold">{{ avg_ratings }}</span>
                        </div>
                    </div>

                    <!-- Time/Servings -->
                    <div class="flex space-x-2 mb-1">
                        <div class="flex space-x-1 text-sm">
                            <CalendarClock class="size-4 text-fuchsia-500" />
                            <h5>Prep Time:</h5>
                            <span class="font-semibold">{{ recipe.prep_time }} mins</span>
                        </div>
                        <div class="flex space-x-1 text-sm">
                            <ClockFading class="size-4 text-orange-500" />
                            <h5>Cooking Time:</h5>
                            <span class="font-semibold">{{ recipe.cook_time }} mins</span>
                        </div>
                        <div class="flex space-x-1 text-sm">
                            <Users class="size-4 text-sky-500" />
                            <h5>Servings:</h5>
                            <span class="font-semibold">{{ recipe.servings }}</span>
                        </div>
                        <div class="flex space-x-1 text-sm">
                            <ChartColumnIncreasingIcon class="size-4 text-teal-500" />
                            <h5>Difficulty:</h5>
                            <span class="font-semibold">{{ recipe.difficulty }}</span>
                        </div>
                    </div>
                </div>

                <!-- Ingredients -->
                <div class="xs:col-span-3 flex flex-col space-y-2">
                    <h5 class="border-b-2 border-slate-400 border-dashed dark:text-white font-bold py-1 text-xl mb-2">Ingredients</h5>
                    <section class="border border-amber-50 p-2 rounded-lg" v-for="(ingredient, index) in ingredients" :key="index">
                        <ul class="">
                            <li><strong>Name:</strong> {{ ingredient.name }}</li>
                            <li><strong>Quantity:</strong> {{ ingredient.quantity }}</li>
                            <li><strong>Unit:</strong> {{ ingredient.unit }}</li>
                            <li><strong>Note:</strong> {{ ingredient.note }}</li>
                        </ul>
                    </section>
                </div>

                <div class="xs:col-span-3 col-span-2 space-y-5">
                    <!-- Description -->
                    <section>
                        <h5 class="border-b-2 border-slate-400 border-dashed dark:text-white font-bold py-1 text-xl mb-2">Description</h5>
                        <p class="font-light text-gray-300">
                            {{ recipe.description }}
                        </p>
                    </section>

                    <!-- Instructions -->
                    <section>
                        <h5 class="border-b-2 border-slate-400 border-dashed dark:text-white font-bold py-1 text-xl mb-2">Instructions</h5>
                        {{ recipe.instructions }}
                    </section>
                </div>

                <div class="col-span-3">
                    <h5 class="border-b-2 border-slate-400 border-dashed dark:text-white font-bold py-1 text-xl mb-2">Comments</h5>

                    <section>
                        <CommentsList :comments="comments" />
                    </section>
                </div>

            </div>
            

        </div>
        <div class="mb-4" v-else>
            You don't have permission to view detail.
        </div>
    </div>
</template>