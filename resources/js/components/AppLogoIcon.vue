<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

interface Props {
    className?: HTMLAttributes['class'];
}

defineProps<Props>();
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="256" height="256" viewBox="0 0 256 256" xml:space="preserve">
    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(13.6466926070039 13.646692607003871) scale(2.53 2.53)">
        <path d="M 45 1 C 28.8 1 15.667 14.133 15.667 30.333 C 15.667 50.968 45 89 45 89 s 29.333 -38.032 29.333 -58.667 C 74.333 14.133 61.2 1 45 1 z M 45 42.067 c -6.48 0 -11.733 -5.253 -11.733 -11.733 C 33.267 23.853 38.52 18.6 45 18.6 s 11.733 5.253 11.733 11.733 C 56.733 36.813 51.48 42.067 45 42.067 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(124,175,250); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
        <path d="M 45 43.067 c -7.021 0 -12.733 -5.712 -12.733 -12.733 S 37.979 17.6 45 17.6 c 7.021 0 12.733 5.712 12.733 12.733 S 52.021 43.067 45 43.067 z M 45 19.6 c -5.918 0 -10.733 4.815 -10.733 10.733 S 39.082 41.067 45 41.067 c 5.918 0 10.733 -4.815 10.733 -10.733 S 50.918 19.6 45 19.6 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(51,51,51); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
        <path d="M 45 90 c -0.31 0 -0.603 -0.144 -0.792 -0.39 c -1.206 -1.563 -29.542 -38.54 -29.542 -59.277 C 14.667 13.607 28.274 0 45 0 c 16.726 0 30.333 13.607 30.333 30.333 c 0 20.737 -28.335 57.713 -29.541 59.277 C 45.603 89.856 45.31 90 45 90 z M 45 2 C 29.377 2 16.667 14.71 16.667 30.333 c 0 18.17 23.665 50.756 28.333 57.006 c 4.668 -6.25 28.333 -38.836 28.333 -57.006 C 73.333 14.71 60.623 2 45 2 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(51,51,51); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round"/>
    </g>
    </svg>
    
</template>
