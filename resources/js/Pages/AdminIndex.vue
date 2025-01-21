<script setup>
import {Head, usePage} from '@inertiajs/vue3'
import {computed, reactive} from 'vue'
import { router } from '@inertiajs/vue3'
const props = defineProps({
    items: Array
})
function uploadVideo() {
    const formData = new FormData()
    formData.append('video', document.getElementById('videoFile').files[0])

    console.log(document.getElementById('videoFile').files[0])
    const config = { headers: {'Content-Type': 'multipart/form-data' } }
    axios.post('/admin/playlist/123', formData, config)
        .then(response => {
            console.log(response)
            document.getElementById('videoForm').reset()
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}

function addPlaylist() {
    // const formData = new FormData()
    // formData.append('name', document.getElementById('playlistName').value)
    // formData.append('comment', document.getElementById('playlistComment').value)

    //console.log(formData)
    axios.defaults.timeout = 30000
    console.log(document.getElementById('playlistName').value)
    axios.post('/admin/playlist', {
        name: document.getElementById('playlistName').value,
        comment: document.getElementById('playlistComment').value
    })
        .then(response => {
            document.getElementById('playlistForm').reset()
            router.reload()
        })
        .catch(e => {
            console.log(e)
        })
}


</script>

<template>
    <Head>Панель администратора</Head>
    <form id="playlistForm" @submit.prevent="addPlaylist">
        <input type="text" placeholder="Название плейлиста" id="playlistName">
        <input type="text" placeholder="Комментарий к плейлисту" id="playlistComment">
        <button type="submit">Добавить плейлист</button>
    </form>



<template v-for="item in items">
<a  :href="`/admin/playlist/${item.id}`" class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

<h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{item.name}}</h5>
<p class="font-normal text-gray-700 dark:text-gray-400">{{item.comment}}</p>
</a>
</template>

    <!-- <form id="videoForm" @submit.prevent="uploadVideo">
        <input type="file" placeholder="Загрузить видео" id="videoFile">
        <button type="submit">Загрузить видео</button>
    </form> -->
</template>

<style scoped>

</style>
