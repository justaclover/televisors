<script setup>
import { Head } from '@inertiajs/vue3'
import {onBeforeMount, onMounted, reactive} from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({ device_id: Int16Array })
localStorage.setItem('device_id', props.device_id)
</script>

<template>
    <h1>{{ device_id }}</h1>
</template>

<style scoped>

</style>
