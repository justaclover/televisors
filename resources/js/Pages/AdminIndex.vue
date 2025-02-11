<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive, ref} from 'vue'
import { router } from '@inertiajs/vue3'
const props = defineProps({
    playlists: Array,
    devices: Array
})

</script>

<template>
    <div class="ml-32 pt-20 flex flex-row gap-14 max-w-full">
        <a :href="`/admin/playlist`" class="w-4/12">
            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Плейлисты</h2>

            <template v-for="item in playlists">
                <a  :href="`/admin/playlist/${item.id}`" class="mb-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.name}}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{item.comment}}</p>
                </a>
            </template>
        </a>

        <a :href="`/admin/device`" class="w-4/12">
            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Устройства</h2>

            <template v-for="item in devices">
                <a  :href="`/admin/device/${item.id}`" class="mb-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.id}}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{item.name}}</p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{item.comment}}</p>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{item.location}}</p>
                </a>
            </template>
        </a>
    </div>
</template>

<style scoped>

</style>
