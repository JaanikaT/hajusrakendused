<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

const formatCurrency =(amount:number) => {
    return new Intl.NumberFormat("de-DE", { style: "currency", currency: "EUR" }).format(amount);
}

const updateCart = (id: number, quantity: number | string) => {
    router.post(route('cart.update'),{
        id: id,
        quantity: quantity,
    });
} 
</script>

<template>
    <AppLayout>
        <!-- {{ $page.props.cart }} -->
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
            <div class="bg-white shadow-md rounded-lg p-4">
                <table class="table-auto w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="px-4 py-2">Item</th>
                            <th class="px-4 py-2">Price</th>
                            <th class="px-4 py-2">Quantity</th>
                            <th class="px-4 py-2">Total</th>
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
                <div class="flex items-center justify-end text-right mt-4">
                    <p class="text-xl font-medium">
                        Total: {{ formatCurrency($page.props.cartTotal) }}
                    </p>
                </div>
            </div>
        </div>
    
    </AppLayout>
</template>