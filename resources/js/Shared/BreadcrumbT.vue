<script setup>
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from '@/components/ui/breadcrumb'
import config from '@/helpers/config'

const props = defineProps({
    items: Object,
});

</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <BreadcrumbItem>
                <BreadcrumbLink :href="route(config.admin_route_name + 'dashboard')">
                Dashboard
                </BreadcrumbLink>
            </BreadcrumbItem>
            <BreadcrumbSeparator />

            <div class="flex items-center space-x-2" v-for="(item, index) in items" :key="index">
                <BreadcrumbItem>
                    <BreadcrumbLink :href="item.url" v-if="item.url">
                        {{ item.label }}
                    </BreadcrumbLink>
                    <BreadcrumbPage v-else>
                        {{  item.label }}
                    </BreadcrumbPage>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="item.url" />
            </div>

        </BreadcrumbList>
    </Breadcrumb>
</template>