<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive, ref} from 'vue'
import { router } from '@inertiajs/vue3'
const props = defineProps({
    playlists: Array,
    devices: Array
})
// function uploadVideo() {
//     const formData = new FormData()
//     formData.append('video', document.getElementById('videoFile').files[0])
//
//     console.log(document.getElementById('videoFile').files[0])
//     const config = { headers: {'Content-Type': 'multipart/form-data' } }
//     axios.post('/admin/playlist/123', formData, config)
//         .then(response => {
//             console.log(response)
//             document.getElementById('videoForm').reset()
//             router.reload()
//         })
//         .catch(e => {
//             console.log(e)
//         })
// }
// const form = reactive({
//     name: '',
//     comment: ''
// })
</script>

<template>
    <div class="ml-32 pt-20">
        <section>
            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Плейлисты</h2>

            <template v-for="item in playlists">
                <a  :href="`/admin/playlist/${item.id}`" class="mb-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.name}}</h5>
                    <p class="font-normal text-gray-700 dark:text-gray-400">{{item.comment}}</p>
                </a>
            </template>
        </section>
        <section>
            <h2 class="mb-8 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">Устройства</h2>

            <template v-for="item in devices">
                <a  :href="`/admin/playlist/${item.id}`" class="mb-4 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.id}}</h5>
                </a>
            </template>
        </section>
    </div>
</template>

<style scoped>

</style>
