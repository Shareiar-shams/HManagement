<template>
  <Navbar :isAuthenticated="isAuthenticated" />
  <slot />
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';

const isAuthenticated = computed(() => usePage().props.auth.user !== null);
</script>