<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Box, BrickWall, Folder, Laptop, LayoutGrid, Plane, Signpost, Sun } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        // ikoon imporditud Lucide.vue
        icon: LayoutGrid,
    },
    {
        title: 'Posts',
        href: '/posts',
        icon: Signpost,
    },
    {
        title: 'Products',
        href: '/products',
        icon: Box,
    },
    {
        title: 'My API',
        href: '/display-subjects?type=',
        icon: Plane,
    },
    {
        title: 'Andruse API',
        href: '/display-subjects?type=andrus',
        icon: BrickWall,
    },
    {
        title: 'Kerdi API',
        href: '/display-subjects?type=kert',
        icon: Laptop,
    },
    {
        title: 'Katrini API',
        href: '/display-subjects?type=katrin',
        icon: Sun,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="floating">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
