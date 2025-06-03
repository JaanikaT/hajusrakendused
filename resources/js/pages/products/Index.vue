<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { ShoppingCart, Trash } from 'lucide-vue-next';
import { Link, router } from '@inertiajs/vue3';
import { BreadcrumbItem } from '@/types';


defineProps(['products']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'E-pood',
        href: '/products',
    },
];


const addToCart = (product: any) => {
    router.post(route('cart.add', product), undefined,{
        preserveScroll: true,
    });
};

const clear = () => {
    router.post(route('cart.clear'));
}

const formatCurrency =(amount:number) => {
    return new Intl.NumberFormat("de-DE", { style: "currency", currency: "EUR" }).format(amount);
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" class="p-6">
        <div class="p-6 bg-gray-100 min-h-screen rounded-lg">
            <div class="p-2 flex justify-end">
            <!-- {{ $page.props.cart }} -->
                <div class="flex gap-4">
                    <Button :as="Link" :href="route('cart.checkout')" size="icon" variant="outline" class="relative">
                        <ShoppingCart class="size-6" />
                    
                        <div class="absolute -top-1 -right-1 flex min-h-5 min-w-5 items-center justify-center rounded-full text-white bg-red-400 text-[10px]">
                        {{ $page.props.cartCount}}
                        </div>
                    </Button>    
                    <Button @click="clear" size="icon" variant="destructive" class="relative">
                        <Trash class="size-5" />
                    </Button>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-center mb-6 dark:text-gray-800">Osta siit!</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <Card v-for="product in products" :key="product.id" class="bg-[#fafafa] dark:bg-[#121212] p-4 rounded-lg shadow-md flex flex-col">
                    <div>
                        <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover rounded-t-lg">
                    </div>
                    <div class="flex flex-col h-4/6">    
                        <h2 class="text-lg font-semibold mt-4">{{ product.name }}</h2>
                        <p class="mt-2">{{ product.description }}</p>
                    </div>    
                    <p class="text-xl font-bold mt-4">{{ formatCurrency(product.price) }} </p>
                    
                    <Button class="mt-2 w-full dark:border border-2" @click="addToCart(product)">Lisa korvi</Button>
                    
                </Card>
            </div>
        </div>
    </AppLayout>
</template>