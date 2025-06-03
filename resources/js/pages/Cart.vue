<script setup lang="ts">

import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Link, router, usePage} from '@inertiajs/vue3';
import { ArrowBigLeft } from 'lucide-vue-next';
import axios from 'axios';
import { computed } from 'vue';

const page = usePage();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ostukorv',
        href: '/cart',
    },
];


const formatCurrency =(amount:number) => {
    return new Intl.NumberFormat("de-DE", { style: "currency", currency: "EUR" }).format(amount);
}

const updateCart = (id: number, quantity: number | string) => {
    router.post(route('cart.update'),{
        id: id,
        quantity: quantity,
    });
}


const cartItems = computed(() => {
    return Object.values(page.props.cart).map((item: any) => ({
        name: item.name,
        price: item.price,
        quantity: item.quantity,
    }));
});

const checkout = async () => {
    try {
        const response = await axios.post('/checkout', { items: cartItems.value });
        window.location.href = response.data.url;
    } catch (error) {
        console.error('Stripe checkout error:', error);
        alert('Checkout failed. Please try again.');
    }
};

// const checkout = () => {
//   router.post(route('checkout'), {}, {
//     preserveScroll: true,
//   });
// };

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" class="p-6">
        <!-- {{ $page.props.cart }} -->
        <div class="mx-auto m-8 w-full max-w-screen-lg">
            <div class="flex justify-between gap-4">
                <h1 class="text-2xl font-bold mb-4">Ostukorv</h1>
                <Button :as="Link" :href="route('products.index')">
                    <ArrowBigLeft class="size-4 mr-2"/>Lisa tooteid
                </Button>
            </div>
        </div>        
        <div class="bg-[#fafafa] dark:bg-[#121212] shadow-md rounded-lg p-4">
            <table class="table-auto w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="px-4 py-2">Toode</th>
                        <th class="px-4 py-2">Hind</th>
                        <th class="px-4 py-2">Kogus</th>
                        <th class="px-4 py-2">Kokku</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, id) in $page.props.cart" :key="id" class="border-b mb-4">
                        <td class="flex items-center px-4 py-2">
                            <img :src="item.image" :alt="item.name" class="size-12 mr-4 rounded-lg">
                            <span>{{ item.name }}</span>
                        </td>
                        <td class="px-4 py-2">{{ formatCurrency(item.price) }} </td>
                        <td class="px-4 py-2">
                            <Input class="w-full max-w-24 text-right" 
                                type="number"
                                @update:model-value="(value) => updateCart(id, value)"
                                :min="0" 
                                :model-value="item.quantity"
                            /> 
                        </td>
                        
                        <td class="px-4 py-2">{{ formatCurrency(item.price * item.quantity) }} </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-end text-right mt-6">
                    <p class="text-xl font-semibold">
                        Kogusumma: {{ formatCurrency($page.props.cartTotal) }}
                    </p>
                </div>
                <div class="flex justify-end">
                    <Button @click="checkout">Maksma</Button>
                </div>
            </div>
        </div>
       
    
    </AppLayout>
</template>