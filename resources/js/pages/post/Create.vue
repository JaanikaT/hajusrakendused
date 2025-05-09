<script setup lang="ts"> 

import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3'
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



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create post',
        href: '/posts/Create',
    },
];

const form = useForm({
    title:"",
    description:"",
})

const submit = () => {
    // console.log(form)
    form.post(route('posts.store'))
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="my-12 mx-auto max-w-2xl">
            <!-- käsk shadcn-x-card -->
            <form @submit.prevent="submit">
                <Card>
                    <CardHeader>
                        <CardTitle>Loo postitus</CardTitle>
                        <CardDescription>Lisa uus blogipostitus</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-4">
                        <div>
                            <Label>Pealkiri</Label>
                            <!-- v-model püüab kinni inputi peal tehtud muudatused -->
                            <Input v-model="form.title"></Input>
                            <InputError :message="form.errors.title"></InputError>
                        </div>
                        <div>
                            <Label>Sisu</Label>
                            <Textarea v-model="form.description"></Textarea>
                            <InputError :message="form.errors.description"></InputError>
                        </div>
                    
                    </CardContent>
                    <CardFooter>
                        <Button type ="submit">Salvesta</Button>
                    </CardFooter>
                </Card>
            </form>
            <!-- kuvab vormi all sisestatud infot
             <pre>{{ form }}</pre> -->
        </div>    
        
    </AppLayout>
</template>