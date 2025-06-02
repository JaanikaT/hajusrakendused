<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';


import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardFooter from '@/components/ui/card/CardFooter.vue';
import Button from '@/components/ui/button/Button.vue';
import { ArrowBigLeft } from 'lucide-vue-next';

</script>


<template>
  <AppLayout>
    <div class="flex justify-center my-12 mx-auto max-w-2xl ">   
      <Card class=" bg-[#fafafa] dark:bg-[#121212] p-4 border-solid border-4 border-green-200">
          <CardHeader>
            <CardTitle>Makse edukalt sooritatud</CardTitle> 
          </CardHeader>

          <CardContent class="flex flex-col gap-4">
            Tellimus on kinnitatud, täname ostu eest!
          </CardContent>

          <CardFooter class="flex mt-4 justify-end">
            <Button :as="Link" :href="route('products.index')" >
              <ArrowBigLeft class="size-4"/>Tagasi e-poodi
            </Button>
          </CardFooter>
      </Card>
    </div> 
  </AppLayout>
</template>