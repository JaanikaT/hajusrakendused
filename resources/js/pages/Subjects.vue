<script setup lang="ts">
import Card from '@/components/ui/card/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';


defineProps(['data', 'customFields']);

</script>

<template>
    <AppLayout :breadcrumbs="[]">
        <!-- {{ data }} -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <Card v-for="item in data" :key="item.id" class="bg-white p-4 rounded-lg shadow-md">
                    <img :src="item.image" :alt="item.title" class="w-full h-48 object-cover rounded-t-lg">
                    <h2 class="text-lg font-semibold mt-4">{{ item.title }}</h2>
                    <p class="text-gray-600 mt-2">{{ item.description }}</p>
                    <p class="text-xl font-bold mt-4">{{ item.comfort }} </p>
                    <p class="text-xl font-bold mt-4">{{ item.seats }} </p>
                    
                </Card>
            </div>
    </AppLayout>

</template>