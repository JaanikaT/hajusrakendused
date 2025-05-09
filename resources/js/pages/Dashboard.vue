<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
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
import {onMounted, ref} from 'vue';
import {format, MapMouseEvent, Marker} from 'maplibre-gl';



const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const props = defineProps(['weather', 'city', 'markers'])
//console.log('Markers', props.markers);

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
    if (markerID.value) {
        form.put(route('marker.update', markerID.value));
    } else {
        form.post(route('marker.store'));
    }

    isPopUpVisible.value=false;

}

Radar.initialize('prj_test_pk_6c2848814c44d67c1a039f34825103987f04e92b', { /* map config options */ });

onMounted(() => {
    const map = Radar.ui.map({
        container: 'map', // OR document.getElementById('map')
        style: 'radar-default-v1',
        center: [22.484135162933256, 58.251952773908954], // Kuressaare
        zoom: 12,

    });

    for (let marker of props.markers ){
        
        const visibleMarker = Radar.ui.marker({
            color: '#000257',
            width: 40,
            height: 80,
            // popup: {
            //     text: marker.name,
            //     //text: marker.description,
            // }
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
        form.latitude = e.lngLat.lat;
        form.longitude = e.lngLat.lng;
        markerID.value = undefined;
    

        // const lat = e.lngLat.lat;
        // const lng = e.lngLat.lng;
        // console.log(`Clicked at latitude: ${lat}, longitude: ${lng}`);
    });


}); 
    
</script>
<!-- teha vorm kus saab markerile sisestada pealkirja ja kirjelduse, lisada see andmebaasi ja pärast markeri peale vajutades kuvada kaardil -->
<template>
    <Head title="Dashboard" />
    
    <div v-if="isPopUpVisible" class="absolute z-50 flex w-full h-screen justify-center items-center">
        <form @submit.prevent="submit" method="POST" class="bg-gray-200 p-8 border-solid border-black border-2 flex flex-col gap-2">
            
            <h1>Marker sisestatakse</h1>
            <div class="flex flex-col">
                <p>{{form.longitude}}</p>
                <p>{{form.latitude}}</p>
            </div>
            <h1>Markeri nimi</h1>
            <input v-model="form.title" type="text" name="title" id="title"/>
            <h1>Lisa kirjeldus</h1>
            <input type="text" v-model="form.description" name="description" id="description"/>
            <input type="submit" value="Salvesta marker" class="mt-5 cursor-pointer"/>
        </form>
    </div>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                
                <Card>
                    <CardHeader>
                    <CardTitle>{{ city }}</CardTitle>
                    <CardDescription>ilm</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="weather-details" v-if="weather">
                            <img justify="center"
                                :src=" 'http://openweathermap.org/img/wn/' + weather.weather[0].icon +'@2x.png'"
                            /> 
                            <span class="value">{{ weather.weather[0].description }}</span>  
                            <div class="weather-item">
                                <span class="label">Temperature: </span>
                                <span class="value">{{ weather.main.temp }}°C</span>
                            </div>
                            <div class="weather-item">
                                <span class="label">Humidity: </span>
                                <span class="value">{{ weather.main.humidity }}%</span>
                            </div>
                            <div class="weather-item">
                                <span class="label">Wind Speed: </span>
                                <span class="value">{{ weather.wind.speed }} m/s</span>
                            </div>
                            
                
                        </div>
                    </CardContent>
                    
                </Card>
                
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />{{mapMouseEv?.lngLat}}
                </div>
                <!-- <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">        
                            
                {{ mapMouseEv?.lngLat?.lng }}
                {{ mapMouseEv?.lngLat?.lat }}
            
                <form @submit.prevent="submit">
                    <input 
                        type="text"
                        name="title"
                        id="title"
                        class="border border-gray-300 rounded-md p-2 w-full mb-2 text-black"
                        placeholder="nimi"
                        v-model="form.title"/>
                        <input type="submit" value="Salvesta" class="bg-blue-500 text-white rounded-md p-2 w-full mb-2 cursor-pointer"/>

                </form>
                
            
                </div> -->
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border md:min-h-min">
                <div id="map" style="width: 100%; height: 100%;" />
            </div>
        </div>
    </AppLayout>
</template>
