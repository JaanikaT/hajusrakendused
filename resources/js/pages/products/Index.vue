<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { ShoppingCart, Trash } from 'lucide-vue-next';
import { Link, router } from '@inertiajs/vue3';


defineProps(['products']);


const addToCart = (product: any) => {
    router.post(route('cart.add', product), undefined,{
        preserveScroll: true,
    });
};

const clear = () => {
    router.post(route('cart.clear'));
}

</script>

<template>
    <AppLayout :breadcrumbs="[]">
        <div class="shop-page p-6 bg-gray-100 min-h-screen">
            <div class="p-4 flex justify-end">
            {{ $page.props.cart }}
                <div class="flex gap-4">
                    <Button :as="Link" :href="route('cart.checkout')" size="icon" variant="outline" class="relative">
                        <ShoppingCart class="size-6" />
                    
                        <div class="absolute -top-1 -right-1 flex min-h-5 min-w-5 items-center justify-center rounded-full bg-red-400 text-[10px]">
                        {{ $page.props.cartCount}}
                        </div>
                    </Button>    
                    <Button @click="clear" size="icon" variant="destructive" class="relative">
                        <Trash class="size-5" />
                    </Button>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-center mb-6">Shop</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <Card v-for="product in products" :key="product.id" class="bg-white p-4 rounded-lg shadow-md">
                    <img :src="product.image" :alt="product.name" class="w-full h-48 object-cover rounded-t-lg">
                    <h2 class="text-lg font-semibold mt-4">{{ product.name }}</h2>
                    <p class="text-gray-600 mt-2">{{ product.description }}</p>
                    <p class="text-xl font-bold mt-4">{{ product.price }} €</p>
                    <Button class="mt-2 w-full" @click="addToCart(product)">Add to Cart</Button>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>