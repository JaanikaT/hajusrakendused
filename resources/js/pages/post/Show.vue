<!-- üksiku postituse vaade -->

<script setup lang="ts"> 

import Button from '@/components/ui/button/Button.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';

const props = defineProps(['post'])

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Show posts',
        href: '/posts/Show',
    },
];

const form = useForm({
    comment:''
})

const submit = () => {
    form.post(route('comments.store', props.post),{
        preserveScroll: true,
        onSuccess:()=>{
            form.reset();
        },
    });  
      
}   
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-12 w-full max-w-2xl">
            <div>
                <h1 class="text-2xl font-semibold tracking-wide">{{ post.title }}</h1>
                <p class="text-balance">{{ post.description }}</p>
            </div>
            <!-- {{ post }} -->
            <div class="mt-8">
                <form @submit.prevent="submit">
                    <div class="relative">
                        <Textarea v-model="form.comment" class="h-full w-full"></Textarea>
                        <Button class="absolute bottom-4 right-4 z-10">Salvesta</Button>
                    </div>
                </form>
            </div>
            <div>
                <div>
                    <h1>Kommentaarid</h1>
                </div>
                <ul>
                    <li v-for="comment in post.comments" :key="comment.id">
                        <div>
                            <!-- <p>{{ comment.user }} </p>
                            <p> {{ comment.comment }}</p>
                            <p> {{ comment.created_at_for_humans }}</p> -->
                        </div>
                    </li>
                </ul>    
            </div>
            <pre>{{ post.comments }}</pre>

        </div>    
    </AppLayout>
</template>

