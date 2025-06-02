<script setup lang="ts"> 

import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Link, useForm } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardDescription from '@/components/ui/card/CardDescription.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import Button from '@/components/ui/button/Button.vue';
import Label from '@/components/ui/label/Label.vue';
import InputError from '@/components/InputError.vue';
import { ArrowBigLeft } from 'lucide-vue-next';


const props = defineProps(['post'])

const form = useForm({
    title: props.post.title,
    description: props.post.description
});

const submit = () => {
    form.put(route('posts.update', props.post.id));
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edit post',
        href: '/posts/Edit',
    },
    
];

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs"> 
        <div class="flex justify-center my-12 mx-auto max-w-2xl ">
            <!-- käsk shadcn-x-card -->
            <form @submit.prevent="submit">
                <Card class=" bg-[#fafafa] dark:bg-[#121212]">
                    <CardHeader>
                        <CardTitle>Muuda postitust</CardTitle>
                        <CardDescription>Muuda postitust</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <div>
                            <Label >Pealkiri</Label>
                            <!-- v-model püüab kinni inputi peal tehtud muudatused -->
                            <Input v-model="form.title" type="text"/>
                            <!-- <edit-post :post-id="{{ $post->id }}"></edit-post> -->
                            <InputError :message="form.errors.title"></InputError>
                        </div>
                        <div>
                            <Label>Sisu</Label>
                            <Textarea v-model="form.description"></Textarea>
                            <InputError :message="form.errors.description"></InputError>
                        </div>
                    
                    </CardContent>
                    <CardFooter class="flex justify-between">
                        <Button :as="Link" :href="route('posts.index')" size="icon"  >
                            <ArrowBigLeft class="size-4"/>
                        </Button>
                        <Button type ="submit">Salvesta</Button>
                    </CardFooter>
                </Card>
            </form>
            <!-- kuvab vormi all sisestatud infot
            <pre>{{ form }}</pre> -->
            </div>
       
    </AppLayout>
</template>