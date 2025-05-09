<script setup lang="ts">

import Button from '@/components/ui/button/Button.vue';
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { PenSquare, Trash } from 'lucide-vue-next';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';


defineProps(['posts']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const postToDelete = ref();

const deletePost = () => {
    router.delete(route('posts.destroy', postToDelete.value),{
        onSuccess: () => {
            postToDelete.value = undefined;
        },
    });
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-12 w-full max-w-screen-lg">
            <div class="flex justify-between gap-8 pb-4">
                <h1 class="text-2xl font-semibold tracking-wide">Postitused</h1>
                <Button>Lisa uus postitus</Button>
            </div>
            <div class="rounded-md border shadow-sm">
                <Table>
                    <TableHeader>
                        <TableRow>                            
                            <TableHead>Title</TableHead>                            
                            <TableHead class="text-right">Created At</TableHead>
                            <!-- sr-only -screen readeritele -->
                            <TableHead class="sr-only">Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableCell>
                                <div>
                                    <Link class="hover:underline":href="route('posts.show', post)">{{ post.title }}</Link>
                                    <p class="max-w-[35ch] truncate text-xs text-muted-foreground">{{ post.description }}</p>
                                </div>
                            </TableCell>
                            <TableCell class="text-right">{{ post.created_at_for_humans }}</TableCell>
                            <TableCell class="test-right">
                                <div class="flex justify-end gap-2">
                                    <Button @click="postToDelete = post" variant="destructive" size="icon">
                                        <Trash class="size-4"></Trash>
                                    </Button>
                                    <Button :as="Link" :href="route('posts.edit', post)" variant="outline" size="icon">
                                        <PenSquare class="size-4"/>
                                    </Button>
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
         <AlertDialog :open="!!postToDelete">
           
           <AlertDialogContent>
             <AlertDialogHeader>
               <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
               <AlertDialogDescription>
                 This action cannot be undone. This will permanently delete your account
                 and remove your data from our servers.
               </AlertDialogDescription>
             </AlertDialogHeader>
             <AlertDialogFooter>
               <AlertDialogCancel @click="postToDelete=undefined">Cancel</AlertDialogCancel>
               <AlertDialogAction @click="deletePost">Continue</AlertDialogAction>
             </AlertDialogFooter>
           </AlertDialogContent>
         </AlertDialog>
        <!-- <div>{{ posts }}</div> -->
    </AppLayout>
</template>
