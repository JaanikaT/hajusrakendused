<!-- üksiku postituse vaade -->

<script setup lang="ts"> 
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog';

import { ref, reactive, watch} from 'vue';
import Button from '@/components/ui/button/Button.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ArrowBigLeft, Trash } from 'lucide-vue-next';


const props = defineProps(['post'])

const inertiaFlash = usePage().props.flash || { message: null, type: null };


const flash = reactive({
  message: inertiaFlash.message,
  type: inertiaFlash.type,
});


watch(
  () => inertiaFlash.message,
  (newMessage) => {
    flash.message = newMessage;
    flash.type = inertiaFlash.type;

    if (newMessage) {
      setTimeout(() => {
        flash.message = null;
        flash.type = null;
      }, 4000); 
    }
  },
  { immediate: true }
);

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

const commentToDelete = ref<number | null>(null);


const deleteComment = (id: number | null) => {
  if (!id) return;

  commentToDelete.value = null;

  router.delete(route('comments.destroy', id), {
    preserveScroll: true,
    preserveState: false,
  });
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div v-if="flash.message" :class="['dark: text-gray-700 text-center mb-4 p-3 rounded', 
        flash.type === 'success' ? 'bg-green-200' : 'bg-red-200']">
            {{ flash.message}}
        </div>
        <div class="mx-auto my-12 w-full max-w-2xl">
            
            <div class="flex justify-end">
                <Button :as="Link" :href="route('posts.index')" size="icon"  >
                            <ArrowBigLeft class="size-4"/>
                        </Button>
            </div>
            <div>
                <h1 class="text-2xl font-semibold tracking-wide">{{ post.title }}</h1>
                <p class="text-balance">{{ post.description }}</p>
            </div>
            <!-- {{ post }} -->
            <div class="mt-8">
                <form @submit.prevent="submit">
                    <div class="relative">
                        <Textarea v-model="form.comment" class="h-full w-full" placeholder="Ei kommentaari..."</Textarea>
                        <Button class="absolute bottom-4 right-4 z-10">Salvesta</Button>
                    </div>
                </form>
            </div>
            <div class="mt-8">
                <div>
                    <h1 class="font-semibold text-lg mb-3">Kommentaarid:</h1>
                </div>
                <ul>
                    <li v-for="comment in post.comments" :key="comment.id">
                        <div class="flex flex-col border-solid border-2 rounded-lg mb-4 p-2 gap-2">
                            <div class="flex justify-between">
                                <p class="font-semibold">{{ comment.user.name }} </p>
                                <p class="text-xs"> {{ comment.created_at_for_humans }}</p>
                            </div>
                            
                            <p> {{ comment.comment }}</p>
                        
                            <div class="flex justify-end">
                                <Button @click="commentToDelete = comment.id" variant="destructive" size="icon">
                                        <Trash class="size-4"></Trash>
                                </Button>
                            </div>
                        </div>
                    </li>
                </ul>    
            </div>
            <!-- <pre>{{ post.comments }}</pre> -->

        </div>
        <AlertDialog :open="commentToDelete !== null">
        <AlertDialogContent>
            <AlertDialogHeader>
            <AlertDialogTitle>Soovid kommentaari kustutada?</AlertDialogTitle>
            <AlertDialogDescription>
                Seda ei saa tagasi võtta.
            </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
            <AlertDialogCancel @click="commentToDelete = null">Tühista</AlertDialogCancel>
            <AlertDialogAction @click="()=> deleteComment(commentToDelete)">Kustuta</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>

