<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import Radar from 'radar-sdk-js';
import 'radar-sdk-js/dist/radar.css'
import {onMounted, ref, reactive } from 'vue';
import {format, MapMouseEvent, Marker} from 'maplibre-gl';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import { ArrowBigLeft, BrickWall, Laptop, Plane, ShoppingCart, Sun, Trash } from 'lucide-vue-next';
import Button from '@/components/ui/button/Button.vue';
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import InputError from '@/components/InputError.vue';




const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps(['weather', 'city','markers'])
//console.log('Markers', props.markers);
const markers = ref([...props.markers]); 
const mapMouseEv = ref<MapMouseEvent>();
const isPopUpVisible = ref<boolean>(false);
const markerID = ref<number>();

const form = useForm({
    title: '',
    description: '',
    latitude: 0,
    longitude: 0,
});

const submit = () => {
//   form.put(route('marker.update', markerID.value), {
//     onSuccess: () => {
//       console.log('Marker updated successfully');
//       isPopUpVisible.value = false;
//     },
//     onError: (errors) => {
//       console.error('Error updating marker:', errors);
//     },
//   });
    // form.put(route('marker.update', markerID.value), {
    // preserveScroll: true,
    // onSuccess: () => {
    //     console.log('✅ Marker updated');
    //     isPopUpVisible.value = false;
    //     form.reset(); // optional: clears the form
    //     markerID.value = undefined;
    // },
    // onError: (errors) => {
    //     console.error('❌ Update failed:', errors);
    // },
    // });

    form.put(route('marker.update', markerID.value), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('✅ Marker updated');
            isPopUpVisible.value = false;

            // Find and update the marker in `markers`
            const index = markers.value.findIndex(m => m.id === markerID.value);
            if (index !== -1) {
            markers.value[index] = {
                ...markers.value[index],
                name: form.title,
                description: form.description,
                latitude: form.latitude,
                longitude: form.longitude,
            };
            }

            form.reset();
            markerID.value = undefined;
        },
        onError: (errors) => {
            console.error('❌ Update failed:', errors);
        },
    });
};

// const submit = () => {
//     if (markerID.value) {
//         form.put(route('marker.update', markerID.value), {
//             preserveScroll: true,
//             onSuccess: () => {
//                 console.log('✅ Marker updated');
//                 isPopUpVisible.value = false;
//             },
//             onError: (errors) => {
//                 console.error('❌ Error updating marker:', errors);
//             }
//         });
//     } else {
//         form.post(route('marker.store'), {
//             preserveScroll: true,
//             onSuccess: () => {
//                 console.log('✅ Marker added');
//                 isPopUpVisible.value = false;
//             },
//             onError: (errors) => {
//                 console.error('❌ Error creating marker:', errors);
//             }
//         });
//     }
// };

// const submit = () => {
    
//     if (markerID.value) {
//         form.put(route('marker.update', markerID.value));
//     } else {
//         form.post(route('marker.store'));
//     }

//     isPopUpVisible.value=false;

// }

Radar.initialize('prj_test_pk_6c2848814c44d67c1a039f34825103987f04e92b', { /* map config options */ });

onMounted(() => {
    const map = Radar.ui.map({
        container: 'map', // OR document.getElementById('map')
        style: 'radar-light-v1',
        center: [22.484135162933256, 58.251952773908954], // Kuressaare
        zoom: 12,

    });

    for (let marker of markers.value ){
        
        const visibleMarker = Radar.ui.marker({
            color: '#000257',
            width: 40,
            height: 80,
            anchor: 'bottom',
        })
        .setLngLat([marker.longitude, marker.latitude])
        
        .addTo(map);

        visibleMarker.on("click", (e) => {
            isPopUpVisible.value = true;
            form.title = marker.name
            form.description = marker.description
            form.longitude = marker.longitude
            form.latitude = marker.latitude
            markerID.value = marker.id
            
        })
    }
    

    // map.on('click', (e) => {
    //     console.log(e.lnglat)
    // });

    map.on("click" , (e) => {
        mapMouseEv.value = e;
        isPopUpVisible.value=true;
        form.reset();
        form.latitude = e.lngLat.lat;
        form.longitude = e.lngLat.lng;
        markerID.value = undefined;
    });
});    
    const closePopup = () => {
        isPopUpVisible.value = false;
        form.reset();
        markerID.value = undefined;
    };

const deleteMarker = () => {
  if (!markerID.value) return;

  form.delete(route('marker.destroy', markerID.value), {
    preserveScroll: true,
    onSuccess: () => {
      //console.log('marker kustutatud');
      // Remove marker from local state
      markers.value = markers.value.filter(m => m.id !== markerID.value);
      isPopUpVisible.value = false;
      form.reset();
      markerID.value = undefined;
    },
    onError: (errors) => {
      console.error('❌ Delete failed:', errors);
    }
  });
};
    
</script>

<template>
    <Head title="Dashboard" />
    
    <div name="addMarkerPopUp" v-if="isPopUpVisible" class="absolute z-50 flex w-full h-screen justify-center items-center">
        <form @submit.prevent="submit" method="POST" class="  bg-[#fafafa] dark:bg-[#121212] border-solid border-2 rounded-lg flex flex-col gap-2">
            <Card class="flex flex-col">
                <CardHeader>
                    <CardTitle>Marker sisestatakse</CardTitle>
                    <CardDescription>
                        <p>{{ form.longitude }}</p>
                        <p>{{ form.latitude }}</p>
                    </CardDescription>
                </CardHeader>
                
                <CardContent class="flex flex-col gap-4">
                    <div class="flex flex-col">
                        <Label>Markeri nimi</Label>
                        <Input v-model="form.title" type="text" name="title" id="title" />
                        <InputError :message="form.errors.title"></InputError>
                    </div>
                    <div class="flex flex-col">
                        <Label>Kirjeldus</Label>
                        <Input type="text" v-model="form.description" name="description" id="description" />
                        <InputError :message="form.errors.description"></InputError>
                    </div>
                
                </CardContent>
                <CardFooter class="flex justify-between">
                    <Button @click="closePopup" size="icon"  >
                        <ArrowBigLeft class="size-4"/>
                    </Button>
                    <div class="flex gap-2">
                        
                        <Button v-if="markerID" type="button" variant="destructive" @click="deleteMarker" size="icon">
                            <Trash class="size-4"></Trash>
                        </Button>
                        <Button type="submit">
                        {{ markerID ? 'Uuenda markerit' : 'Salvesta' }}
                        </Button>
                    </div>
                </CardFooter>
            </Card>
        </form>
    </div>

    
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                
                <Card class="flex flex-col">
                    <CardHeader>
                    <CardTitle>{{ city }}</CardTitle>
                    <CardDescription>ilm</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div name="weather-details" class="" v-if="weather">
                            <img justify="center"
                                :src=" 'http://openweathermap.org/img/wn/' + weather.weather[0].icon +'@2x.png'"
                            /> 
                            <span class="value">{{ weather.weather[0].description }}</span>  
                            <div class="weather-item">
                                <span class="label">Temperatuur: </span>
                                <span class="value">{{ weather.main.temp.toFixed(1) }}°C</span>
                            </div>
                            <div class="weather-item">
                                <span class="label">Niiskus: </span>
                                <span class="value">{{ weather.main.humidity }}%</span>
                            </div>
                            <div class="weather-item">
                                <span class="label">Tuule kiirus: </span>
                                <span class="value">{{ Math.round(weather.wind.speed) }} m/s</span>
                            </div>
                        </div>
                    </CardContent>
                </Card>
                
                <Card class="flex flex-col">
                    <CardHeader class="flex h-1/2">
                    <CardTitle>E-pood</CardTitle>
                    <CardDescription>Osta mugavalt kodust lahkumata</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-8">
                        <p>Vaata siit, mida poes pakutakse</p>
                        <Button :as="Link" :href="route('products.index')" class="flex align-bottom">
                            <ShoppingCart class="size-4"/>Mine e-poodi
                        </Button>
                    </CardContent>
                </Card>
                <Card class="flex flex-col">
                    <CardHeader class="flex">
                    <CardTitle>API-d</CardTitle>
                    <CardDescription>Vaata teiste loodud API-sid</CardDescription>
                    </CardHeader>
                    <CardContent class="flex flex-col gap-2">
                        
                        <Button :as="Link" :href="('display-subjects?type=')">
                            <Plane class="size-4"/>Minu API
                        </Button>
                        <Button :as="Link" :href="('display-subjects?type=andrus')">
                            <BrickWall class="size-4"/>Andruse API
                        </Button>
                        <Button :as="Link" :href="('display-subjects?type=kert')">
                            <Laptop class="size-4"/>Kerdi API
                        </Button>
                        <Button :as="Link" :href="('display-subjects?type=katrin')">
                            <Sun class="size-4"/>Katrini API
                        </Button>
                    </CardContent>
                </Card>
               
               
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div id="map" style="width: 100%; height: 100%;" />
            </div>
        </div>
    </AppLayout>
</template>
